<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Helpers;

use Illuminate\Support\Collection;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax;

final class TaxHelper
{

    /**
     * @param float $taxableAmount Le soust-total contenant déjà des reductions
     * @param BcOrganization $organization
     * @param array|null $itemTaxes
     * @return array
     */
   public static function generateCalculatedTaxes(float $taxableAmount, BcOrganization $organization, ?array $itemTaxes = []): array
    {

        if ($itemTaxes){
            return $itemTaxes;
        }
        /**
         * Toutes les taxes actives liées à l'organisation
         * @var Collection
         */
        $orgTaxes = $organization->relatedEntities(BcTax::class)
                                    ->active()
                                    ->orderBy('applied_in_taxable_amount')
                                    ->get();

        // Calculer les montants des taxes
        $taxes = self::calculateTaxesAmount($taxableAmount,$orgTaxes);

        return [
            'details' => $taxes,
            'total' => collect($taxes)->sum('amount'),
        ];
    }


    /**
     * Calcule le montant total des taxes appliquées au montant taxable.
     *
     * Certaines taxes sont appliquées en premier et modifient le montant taxable,
     * ce qui influence les taxes suivantes.
     *
     * @param float $taxableAmount Le montant initial (sous-total, après réductions).
     * @param Collection $taxes Collection des taxes à appliquer.
     * @return array Liste des taxes calculées avec leur montant.
     */
    public static function calculateTaxesAmount(float $taxableAmount, Collection $taxes): array
    {

        /**
         * Exemples :
         * $taxableAmount = 200
         *
         * $taxes = collect([
                (object)[
                    'tax_number' => '136THS',
                    'value' => 10,
                    'applied_in_taxable_amount' => true,
                    'tax_type' => 'PERCENTAGE',
                ],
                (object)[
                    'tax_number' => '136217890',
                    'value' => 5,
                    'applied_in_taxable_amount' => false,
                    'tax_type' => 'PERCENTAGE',
                ],
                (object)[
                    'tax_number' => '136AR',
                    'value' => 9.75,
                    'applied_in_taxable_amount' => false,
                    'tax_type' => 'PERCENTAGE',
                ],
         * ])
         *
         * $result = [
                        [
                            'type' => 'PERCENTAGE',
                            'number' => '136THS',
                            'value' => 10,
                            'amount' => 20,  // 10% de 200 , $taxableAmount = 220
                        ],
                        [
                            'type' => 'PERCENTAGE',
                            'number' => '136217890',
                            'value' => 5,
                            'amount' => 11,  // 5% de 220
                        ],
                        [
                            'type' => 'PERCENTAGE',
                            'number' => '136AR',
                            'value' => 9.75,
                            'amount' => 21.45,  // 9.75% de 220
                        ],
                    ]
         */


        /**
         * Toutes les taxes qui s'appliquent directement sur le sous-total (applied_in_taxable_amount = true) étant placées
         * en prémier doivent modifier $taxableAmount pour que les autres taxes s'applique en fonction
         *
         * @var array
         */
        return $taxes->map(function (BcTax $tax) use (&$taxableAmount) {

                        // Calcul de la taxe en fonction du montant taxable actuel
                        $taxAmount = $tax->getCalculateAmount($taxableAmount);

                        // Si cette taxe modifie le montant taxable,
                        if ($tax->applied_in_taxable_amount) {
                            // On met à jour taxableAmount en incluant la taxe en cours
                            $taxableAmount += $taxAmount;
                        }

                        return [
                            'type' => $tax->tax_type,
                            'number' => $tax->tax_number,
                            'value' => $tax->value,
                            'amount' => $taxAmount,
                        ];

                    })->toArray();
    }
}