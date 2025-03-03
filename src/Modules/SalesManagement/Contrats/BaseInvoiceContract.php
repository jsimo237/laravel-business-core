<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property BaseOrderContract order
 * @property RecipientInteractWithOrderAndInvoice recipient
 * @property Collection payments
 */
interface BaseInvoiceContract
{

    public function refreshInvoice() : void;

    public function payments() : HasMany;

    public function order() : BelongsTo | BaseOrderContract;

    public function recipient() : MorphTo | RecipientInteractWithOrderAndInvoice;

    public function handleInvoicePaied() :void;

    public function send() :void;
}