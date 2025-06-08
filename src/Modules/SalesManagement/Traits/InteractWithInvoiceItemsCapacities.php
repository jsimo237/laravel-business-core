<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\InvoiceItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

trait InteractWithInvoiceItemsCapacities
{

    public function getInvoice(): ?BaseInvoiceContract
    {
        return $this->invoice;
    }

    public function getInvoiceItem(): ?InvoiceItemContract
    {
        return $this->invoiceItem;
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(
                    Invoice::class,
                    InvoiceItem::class,
                    InvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Invoice
                    'id',               // Clé primaire sur Product
                    'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
                )
                ->where(
                    (new InvoiceItem)->getTable().".".InvoiceItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                ) ;
    }

    public function invoiceItem(): MorphOne
    {
        return $this->morphOne(
                    InvoiceItem::class,
                    InvoiceItem::MORPH_FUNCTION_NAME,
                    InvoiceItem::MORPH_TYPE_COLUMN,
                );
    }

    public function invoices(): HasManyThrough
    {
        return $this->hasManyThrough(
                    Invoice::class,
                    InvoiceItem::class,
                    InvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Invoice
                    'id',               // Clé primaire sur Product
                    'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
                )
                ->where(
                    (new InvoiceItem)->getTable().".".InvoiceItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(
                    InvoiceItem::class,
                    InvoiceItem::MORPH_FUNCTION_NAME,
                    InvoiceItem::MORPH_TYPE_COLUMN,
                );
    }
}