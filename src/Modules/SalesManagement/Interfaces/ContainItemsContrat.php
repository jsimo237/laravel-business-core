<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property BaseOrderItem|BaseInvoiceItem items
 */
interface ContainItemsContrat
{

    /**
     * @return HasMany
     */
    public function items(): HasMany;
}