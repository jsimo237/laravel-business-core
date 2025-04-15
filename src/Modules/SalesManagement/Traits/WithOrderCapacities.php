<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\TaxableItemContrat;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Support\Constants\DiscountType;

trait WithOrderCapacities
{


    public static function bootWithOrderCapacities(){

    }


    public function getRelationsMethods(): array
    {
        return [];
    }

    public function getObjectName(): string
    {
        return $this->code;
    }

    /************ Relations ************/

    /**
     * An Order is created by a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(BcUser::class,"user_id");
    }

    /************ computing functions  ************/

    /**
     * Get the order total amount
     *
     * @return float|int
     */
    public function getTotalAmount(): float|int
    {
        return $this->getSubTotalAmount()
                + $this->getTaxes()['total']
                - $this->getDiscounts()['total'];
    }

    /**
     * Get the order total amount
     * Note : Si la somme ne change pas fréquemment,
     * on va la cacher pour améliorer les performances.
     * @return float
     */
    public function getSubTotalAmount(): float
    {
//        return Cache::remember("order_{$this->id}_subtotal", 60, function () {
//                    return $this->items->sum(fn(BaseOrderItem $item) => $item->getItemSubTotalAmount());
//                });

        return $this->items->sum(fn(TaxableItemContrat $item) => $item->getItemSubTotalAmount());
    }

    /**
     * Get the order total amount
     *
     * @return array
     */
    public function getTaxes(): array
    {
        /**
         * Récupérer les taxes de tous les éléments en une seule collection
         *
         * Utilisation de flatMap() pour aplatir les taxes de tous les items dans une seule collection.
         * Cela permet de récupérer toutes les lignes de taxes de chaque item en une seule collection sans avoir à faire de boucle manuelle.
         */
        $taxesDetails = $this->items->flatMap(function (TaxableItemContrat $item) {
                            return $item->getItemTaxes()['details'];
                        });

        /**
         * Regrouper les taxes par nom
         *
         * Ensuite, nous utilisons groupBy() pour regrouper les taxes par leur nom (name).
         * Cela permet de gérer les taxes ayant le même nom sans avoir à vérifier manuellement avec isset().
         *
         * Ensuite, nous utilisons map() pour calculer le montant total de chaque groupe de taxes en additionnant
         * les montants de chaque groupe (sum('amount')).
         * Utilisation first() pour récupérer la première ligne de taxe du groupe et y ajouter le montant total calculé.
         */
        $groupedTaxes = $taxesDetails->groupBy('name')
                                    ->map(function ($taxGroup) {
                                        // Additionner les montants des taxes par nom
                                        $totalAmount = $taxGroup->sum('amount');
                                        // Retourner une seule entrée avec le montant total pour chaque taxe
                                        return $taxGroup->first() + ['amount' => $totalAmount];
                                    });

        // Calculer le total global des taxes
        $totalTaxes = $groupedTaxes->sum('amount');

        return [
            'details' => $groupedTaxes->values(),
            'total' => $totalTaxes,
        ];
    }


    /**
     * Get the order total discount amount
     *
     * @return array
     */
    public function getDiscounts(): array
    {
        // Récupérer toutes les réductions des éléments en une seule collection
        $itemsDiscountsAmount = $this->items->sum(fn(TaxableItemContrat $item) => $item->getItemDiscountAmount());

        // Calculer la valeur des réductions sur les articles
        $subtotal = $this->getSubTotalAmount();
        $itemsDiscountsValue = $subtotal != 0 ? ($itemsDiscountsAmount / $subtotal) * 100 : 0;

        // Initialiser les réductions calculées
        $calculatedDiscounts = [
                                    'details' => [],
//                                    'details' => [
//                                        [
//                                            'name' => 'ITEMS_DISCOUNTS',
//                                            'type' => DiscountType::PERCENTAGE->value,
//                                            'amount' => $itemsDiscountsAmount,
//                                            'value' => $itemsDiscountsValue,
//                                        ],
//                                    ],
                                    'total' => 0,
                                ];

        // Calculer les réductions supplémentaires sur la commande
        $orderDiscounts = collect($this->discounts)
                            ->map(function ($discount) use ($subtotal) {
                                $discountAmount = 0;

                                if ($discount['type'] == DiscountType::AMOUNT->value) {
                                    $discountAmount = $discount['value'];
                                } elseif ($discount['type'] == DiscountType::PERCENTAGE->value) {
                                    $discountAmount = ($subtotal * ($discount['value'] / 100));
                                }

                                // Ajouter le montant calculé à la réduction
                                $discount['amount'] = $discountAmount;

                                return $discount;
                            });

        // Ajouter les réductions de la commande aux réductions calculées
        $totalDiscounts = $itemsDiscountsAmount + $orderDiscounts->sum('amount');
        $calculatedDiscounts['details'] = array_merge($calculatedDiscounts['details'], $orderDiscounts->toArray());
        $calculatedDiscounts['total'] = $totalDiscounts;

        return $calculatedDiscounts;
    }
}