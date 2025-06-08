<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Activable;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\TaxeType;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

/**
 * @property string|int $id
 * @property string $name
 * @property string $label
 * @property string $description
 * @property string $tax_number
 * @property string $tax_type
 * @property string $calculation_type
 * @property string $calculation_base
 * @property float $value
 * @property bool $is_active
 * @property bool $applied_in_taxable_amount
 */
class Tax extends BaseModel implements EventNotifiableContract
{

    use  Activable;

    const TAX_CALCULATION_TYPE_AMOUNT = 'AMOUNT';

    const TAX_CALCULATION_TYPE_PERCENTAGE = 'PERCENTAGE';

    const TAX_TYPE_SALES = 'SALES';

    const TAX_TYPE_PURCHASES = 'PURCHASES';

    const TAX_CALCULATION_BASE_BEFORE_TAX = 'BEFORE_TAX';

    const TAX_CALCULATION_BASE_AFTER_TAX = 'AFTER_TAX';


    protected $table = "sales_mgt__taxes";

    protected $fillable = [
        'active',
        'name',
        'label',
        'tax_number',
        'tax_type',
        'calculation_type',
        'calculation_base',
        'value',
        'applied_in_taxable_amount',
        'description',
    ];

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search): mixed
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
