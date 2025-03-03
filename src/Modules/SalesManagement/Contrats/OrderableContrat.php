<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


/**
 * @property BaseOrderContract $order
 * @property BaseOrderItemContrat $orderItem
 * @property BaseInvoiceContract $invoice
 * @property BaseInvoiceItemContrat $invoiceItem
 */
interface OrderableContrat
{

    public function getItemId(): string|int;

    public function getSku(): string;

    public function getName(): string;

    public function getExcerpt(): ?string;

    public function getProductId(): string;

    public function getOrder(): ?BaseOrderContract;
    public function getInvoice(): ?BaseInvoiceContract;
    public function getInvoiceItem(): ?BaseInvoiceItemContrat;
    public function getOrderItem(): ?BaseOrderItemContrat;


    public function invoice() : HasOneThrough;
    public function invoiceItem() : MorphOne;

    public function order () : HasOneThrough;
    public function orderItem() : MorphOne;
}