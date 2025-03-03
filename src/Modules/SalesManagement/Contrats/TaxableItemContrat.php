<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface TaxableItemContrat
{

    public function taxGroups(): MorphToMany;
}