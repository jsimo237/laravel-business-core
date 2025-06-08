<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Invoiceable;

class InvoiceItem extends BaseInvoiceItem
{
    protected $table = "sales_mgt__invoice_items";

    const MORPH_ID_COLUMN = "invoiceable_id";
    const MORPH_TYPE_COLUMN = "invoiceable_type";
    const MORPH_FUNCTION_NAME = "invoiceable";

    // relation
    /**
     * an invoiceitem belongs to an invoice
     */
    public function invoice(): Belongsto
    {
        return $this->belongsTo(Invoice::class,"invoice_id");
    }

    /**
     * an event belongs to a user
     */
    public function invoiceable(): Morphto
    {
        return $this->morphTo(
                    self::MORPH_FUNCTION_NAME,
                    self::MORPH_TYPE_COLUMN,
                    self::MORPH_ID_COLUMN
                );
    }


    public function getInvoice(): BaseInvoice
    {
        return $this->invoice;
    }

    public function getInvoiceable(): ?Invoiceable
    {
        return $this->invoiceable;
    }

    public function getItemId(): string|int
    {
        return $this->getInvoiceable()?->getKey();
    }

    public function getSku(): string
    {
        return $this->getInvoiceable()?->sku;
    }

    public function getName(): string
    {
        return $this->code;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                        Order::class,  // Modèle cible (Order)
                        Invoice::class, // Modèle intermédiaire (Invoice)
                        'id',             // Clé primaire de Invoice (intermédiaire)
                        'id',             // Clé primaire de Order
                        'invoice_id',     // Clé étrangère dans InvoiceItem (vers Invoice)
                        'order_id'        // Clé étrangère dans Invoice (vers Order)
                    );

    }
}