<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;


use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property BaseOrderContract[] orders
 * @property BaseInvoiceContract[] invoices
 */
interface RecipientInteractWithOrderAndInvoice
{

    public function orders() : MorphMany;

    public function invoices() : MorphMany;

}