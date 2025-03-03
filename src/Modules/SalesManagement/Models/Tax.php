<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Kirago\BusinessCore\Enums\TaxeType;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

/**
 * @property bool $active
 * @property string $name
 * @property string $label
 * @property string $tax_number
 * @property string $tax_type
 * @property string $calculation_type
 * @property string $calculation_base
 * @property float $value
 * @property bool $applied_in_taxable_amount
 */
class Tax extends BaseModel implements EventNotifiableContract
{
    const TAX_CALCULATION_TYPE_AMOUNT = 'AMOUNT';

    const TAX_CALCULATION_TYPE_PERCENTAGE = 'PERCENTAGE';

    const TAX_TYPE_SALES = 'SALES';

    const TAX_TYPE_PURCHASES = 'PURCHASES';

    const TAX_CALCULATION_BASE_BEFORE_TAX = 'BEFORE_TAX';

    const TAX_CALCULATION_BASE_AFTER_TAX = 'AFTER_TAX';



    protected array $fillable = [
        'active',
        'name',
        'label',
        'tax_number',
        'tax_type',
        'calculation_type',
        'calculation_base',
        'value',
        'excerpt',
    ];

    /**
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('label', 'LIKE', "%$search%")
                        ->orWhere('tax_number', 'LIKE', "%$search%");
    }

    public function getObjectName(): string
    {
       return $this->name;
    }


    public function getCalculateAmount(float|int $amount): float|int
    {
        $value = $this->value;

        return match ($this->tax_type) {
                        TaxeType::AMOUNT->value => $value,  // Taxe fixe
                        TaxeType::PERCENTAGE->value => $amount * ($value / 100), // Pourcentage appliqué au montant
                        default => 0, // Cas par défaut, aucune taxe
                    };
    }
}
