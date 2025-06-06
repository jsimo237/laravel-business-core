<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface TaxableItemContrat
{

    public function taxGroups(): MorphToMany;
}