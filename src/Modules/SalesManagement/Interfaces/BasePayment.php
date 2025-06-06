<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


/**
 * @property BaseInvoice invoice
 * @property BaseOrder order
 */
interface BasePayment
{

    public function refreshPayment() : void;

    public function invoice() : BelongsTo;
    public function order() : HasOneThrough;

    public function getOrder() : BaseOrder;
    public function getInvoice() : BaseInvoice;

    public function handlePaymentCompleted() : void;

}