<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup;

trait HasTaxGroup
{

    public function taxGroups(): MorphToMany
    {
        return $this->morphToMany(
            BcTaxGroup::class,
            'model',
            'model_tax_groups',
            'model_id',
            'tax_group_id'
        );
    }
}