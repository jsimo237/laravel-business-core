<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Models\Observers;

use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;

class RoleObserver{


    /** Efface definitivement le rôle
     * @param BcRole $role
     */
    public function forceDeleted(BcRole $role){
        $tableNames = config('permission.table_names'); // [array]
        $columnNames = config('permission.column_names'); // [array]
        $role_id = $role->id;

        //supprime les liaisons avec les autres models
        DB::table($tableNames['model_has_roles'])
            ->where($columnNames['role_pivot_key'],$role_id)
            ->delete();

        //supprime les liaisons avec les permissions
        DB::table($tableNames['role_has_permissions'])
            ->where($columnNames['role_pivot_key'],$role_id)
            ->delete();
    }
}
