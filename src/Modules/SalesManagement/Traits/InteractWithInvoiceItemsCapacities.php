<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

trait InteractWithInvoiceItemsCapacities
{

    public function getInvoice(): ?BaseInvoice
    {
        return $this->invoice;
    }

    public function getInvoiceItem(): ?BaseInvoiceItem
    {
        return $this->invoiceItem;
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(
                    BcInvoice::class,
                    BcInvoiceItem::class,
                    BcInvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Invoice
                    'id',               // Clé primaire sur Product
                    'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
                )
                ->where(
                    (new BcInvoiceItem)->getTable().".".BcInvoiceItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                ) ;
    }

    public function invoiceItem(): MorphOne
    {
        return $this->morphOne(
                    BcInvoiceItem::class,
                    BcInvoiceItem::MORPH_FUNCTION_NAME,
                    BcInvoiceItem::MORPH_TYPE_COLUMN,
                );
    }

    public function invoices(): HasManyThrough
    {
        return $this->hasManyThrough(
                    BcInvoice::class,
                    BcInvoiceItem::class,
                    BcInvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
                    'id',               // Clé primaire sur Invoice
                    'id',               // Clé primaire sur Product
                    'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
                )
                ->where(
                    (new BcInvoiceItem)->getTable().".".BcInvoiceItem::MORPH_TYPE_COLUMN,
                    (new static)->getMorphClass()
                );
    }

    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(
                    BcInvoiceItem::class,
                    BcInvoiceItem::MORPH_FUNCTION_NAME,
                    BcInvoiceItem::MORPH_TYPE_COLUMN,
                );
    }
}