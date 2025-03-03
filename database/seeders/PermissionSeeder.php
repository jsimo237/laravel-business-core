<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Seeder;
use Kirago\BusinessCore\Data\UserPermissionsData;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;


class PermissionSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        echo(strtoupper("[BEGIN] Permissions \n"));
        $guards = [
            (new User)->guardName() => UserPermissionsData::items(),
//            "briefcase" => config("briefcase-permissions"),
        ];

        foreach ($guards as $guard => $permissions) {
            $this->command->info(__("Detection de :count permission(s) dans la guarde ':guard'",['guard' => $guard, "count" => count($permissions) ]));
            if ($permissions){
               // Permission::upsert($permissions)
                foreach ($permissions as $permission) {
                    try {
                        $permission['guard_name'] = $guard;
                        Permission::updateOrCreate(
                            [
                                "name" => $permission["name"],
                                "guard_name" => $guard,
                            ],
                            $permission
                        );
                    }catch (\Exception $exception){
                        echo($exception->getMessage());
                        continue;
                    }
                }
            }
            echo(__(":count permission(s) dans la guarde ':guard' \n",['guard' => $guard, "count" => format_amount(Permission::where('guard_name',$guard)->count()) ]));
        }
        echo(strtoupper("[END] Permissions \n"));
    }
}
