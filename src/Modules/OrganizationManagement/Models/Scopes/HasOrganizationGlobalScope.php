<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HasOrganizationGlobalScope implements Scope
{

    public function apply(Builder $builder, Model $model){

    }
}