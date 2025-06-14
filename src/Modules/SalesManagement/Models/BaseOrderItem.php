<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\OrderItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Orderable;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\TaxableItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Helpers\TaxHelper;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\HasTaxGroup;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

/**
 * @property string $code
 * @property int|float $quantity
 * @property float $unit_price
 * @property string $note
 * @property float $discount
 * @property array<string, mixed> $taxes
 */
abstract class BaseOrderItem extends Model implements
    TaxableItemContrat,EventNotifiableContract,
    OrderItemContract
{

    use SoftDeletes,HasTaxGroup,Auditable;

    /************ Abstract functions ************/
    abstract public function getOrder() : ?BaseOrderContract;

    abstract public function getOrderable(): ?Orderable;


    /************ computing functions  ************/

    /**
     * Get the order total amount
     *
     * @return float
     */
    public function getItemTotalAmount(): float
    {
        return $this->getItemSubTotalAmount()
                    - $this->getItemDiscountAmount()
                    + $this->getItemTaxes()['total'];
    }

    /**
     * Get the order total amount
     *
     * @return float
     */
    public function getItemSubTotalAmount(): float
    {
        return $this->unit_price * $this->quantity;
    }

    /**
     * Get the order total amount
     */
    public function getTaxableBaseAmount(): float
    {
        return $this->getItemSubTotalAmount() - $this->getItemDiscountAmount();
    }

    /**
     * Get the order total amount
     *
     * @return array<string, array<int<0, max>, array<string, mixed>>|float|int>
     */
    public function getItemTaxes(): array
    {
        return TaxHelper::generateCalculatedTaxes(
                    $this->getTaxableBaseAmount(),
                    $this->getOrganization(),
                    $this->taxes ?? []
                );
    }


    /**
     * Get the order total amount
     */
    public function getItemDiscountAmount(): float
    {
        return $this->getItemSubTotalAmount() * ($this->discount / 100);
    }
}