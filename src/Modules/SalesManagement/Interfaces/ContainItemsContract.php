<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property OrderItemContract|InvoiceItemContract items
 */
interface ContainItemsContract
{

    /**
     * @return HasMany
     */
    public function items(): HasMany;
}