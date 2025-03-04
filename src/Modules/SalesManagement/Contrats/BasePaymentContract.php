<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


/**
 * @property BaseInvoiceContract invoice
 * @property BaseOrderContract order
 */
interface BasePaymentContract
{

    public function refreshPayment() : void;

    public function invoice() : BelongsTo;
    public function order() : HasOneThrough;

    public function getOrder() : BaseOrderContract;
    public function getInvoice() : BaseInvoiceContract;

    public function handlePaymentCompleted() : void;

}