<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
 use Kirago\BusinessCore\Modules\CoresManagement\Models\Traits\Auditable;
 use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
 use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoiceContract;
 use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\InvoiceItemContract;
 use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Invoiceable;
 use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\TaxableItemContrat;
 use Kirago\BusinessCore\Modules\SalesManagement\Helpers\TaxHelper;
 use Kirago\BusinessCore\Modules\SalesManagement\Traits\HasTaxGroup;
 use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;

 abstract class BaseInvoiceItem extends Model implements
    EventNotifiableContract,
    TaxableItemContrat,
    InvoiceItemContract
{

    use SoftDeletes,HasTaxGroup,Auditable;


    /************ Common functions, attributes and constants ************/

    protected $fillable = [
        'code',
        'note',
        'unit_price',
        'quantity',
        'discount',
    ];

    protected $casts = [
        "taxes" => 'array'
    ];

    public function getObjectName(): string
    {
        return $this->code;
    }




    /************ Abstract functions ************/
    abstract public function getInvoice() : BaseInvoiceContract;

    abstract public function getInvoiceable() : ?Invoiceable;


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

    /**
     * Get the Organization or item based on orderable/invoiceable relation
     */
    public function getOrganization(): ?Organization
    {
        return $this->getInvoiceable()?->getOrganization();
    }


 }