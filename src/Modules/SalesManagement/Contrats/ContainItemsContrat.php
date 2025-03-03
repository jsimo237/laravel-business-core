<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface ContainItemsContrat
{

    /**
     * @return HasMany
     */
    public function items(): HasMany;
}