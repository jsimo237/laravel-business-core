<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property BaseInvoiceContract[] invoices
 * @property InvoiceItemContract[] invoiceItems
 * @property BaseInvoiceContract invoice
 * @property InvoiceItemContract invoiceItem
 */
interface Invoiceable
{
    public function getInvoice(): ?BaseInvoiceContract;

    public function getInvoiceItem(): ?InvoiceItemContract;

    public function invoice() : HasOneThrough;

    public function invoiceItem() : MorphOne;

    public function invoices() : HasManyThrough;

    public function invoiceItems() : MorphMany;

}