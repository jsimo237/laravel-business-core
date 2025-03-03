<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;

trait HasTaxGroup
{

    public function taxGroups(): MorphToMany
    {
        return $this->morphToMany(
            TaxGroup::class,
            'model',
            'model_tax_groups',
            'model_id',
            'tax_group_id'
        );
    }
}