<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

// use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * @property RecipientInteractWithOrderAndInvoice recipient
 */
interface BaseOrderContract
{

    public function refreshOrder() : void;

    public function invoice() : HasOne;

    public function user() : BelongsTo;

    public function send() :void;

}