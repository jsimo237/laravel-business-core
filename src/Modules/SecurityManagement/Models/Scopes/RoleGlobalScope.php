<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;

class RoleGlobalScope implements Scope{

    /**Apply the scope to a given Eloquent query builder.
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model){
            $guard = activeGuard();
           // $manager = auth($guard)->user()?->manager;
            $manager = null;
            $builder->when(auth($guard)->check() and filled($manager) ,function ($query) use ($manager){
                          //return $query->where("manager_id", $manager->id);
                        })
                        ->when(request()->filled("guard_name"),function ($query){
                            $table = (new Role)->getTable();
                            return $query->where("$table.guard_name",request()->get("guard_name"));
                        })
            ;
    }

}
