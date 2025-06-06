<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property BaseInvoice[] invoices
 * @property BaseInvoiceItem[] invoiceItems
 * @property BaseInvoice invoice
 * @property BaseInvoiceItem invoiceItem
 */
interface Invoiceable
{
    public function getInvoice(): ?BaseInvoice;

    public function getInvoiceItem(): ?BaseInvoiceItem;

    public function invoice() : HasOneThrough;

    public function invoiceItem() : MorphOne;

    public function invoices() : HasManyThrough;

    public function invoiceItems() : MorphMany;

}