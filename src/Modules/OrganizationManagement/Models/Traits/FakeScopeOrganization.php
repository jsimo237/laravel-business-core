<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * this trait is to add the scope organization witch does nothing to be able to make 
 * filters in the front work on all objects
 */
trait FakeScopeOrganization
{
    /**
     * @param Builder $query
     * @param $organization
     * @return Builder
     */
    public function scopeOrganization( Builder$query, $organization): Builder
    {
        return $query;
    }
}
