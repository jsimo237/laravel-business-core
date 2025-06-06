<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;


use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property BaseOrder[] orders
 * @property BaseInvoice[] invoices
 */
interface RecipientInteractWithOrderAndInvoice
{

    public function orders() : MorphMany;

    public function invoices() : MorphMany;

}