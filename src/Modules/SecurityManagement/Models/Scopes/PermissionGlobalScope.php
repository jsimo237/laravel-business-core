<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;


class PermissionGlobalScope implements Scope{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model){
        $builder->when($guardName = request()->get("guard_name"),function ($query) use ($guardName){
                    return $query->where((new Permission)->getTable().".guard_name",$guardName);
                })
                ->when($groupCode = request()->get("group"),function ($query) use ($groupCode){
                    return $query->where("group",$groupCode);
                })
        ;
    }

}
