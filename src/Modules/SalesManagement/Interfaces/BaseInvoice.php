<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property BaseOrder order
 * @property RecipientInteractWithOrderAndInvoice recipient
 * @property Collection payments
 */
interface BaseInvoice
{

    public function refreshInvoice() : void;

    public function payments() : HasMany;

    public function order() : BelongsTo | BaseOrder;

    public function recipient() : MorphTo | RecipientInteractWithOrderAndInvoice;

    public function handleInvoicePaid() :void;

    public function getTotalPaid() : float;
    public function getTotalRemaining() : float;

    public function send() :void;
}