<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;



/**
 * @property BaseOrderContract $order
 * @property BaseInvoiceContract $invoice
 * @property BaseInvoiceItemContrat $invoiceItem
 * @property BaseInvoiceContract $orderItem
 */
interface InvoiceableContract
{

    public function invoice() : HasOneThrough;
    public function invoiceItem() : MorphOne;

    public function order () : HasOneThrough;
    public function orderItem() : MorphOne;

}