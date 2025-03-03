<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

class RoleSeeder extends Seeder{

    public function run(){
        echo(strtoupper("[BEGIN] Roles \n"));

        $roles = [
            [
                "name" => Role::MANAGER,
                "guard_name" => (new User)->guardName(),
                "editable" => false,
                "permissions" => Permission::where("guard_name",(new User)->guardName())->pluck("id")->toArray()
            ],
        ];
        $users = User::whereIn('email',['joelsimooverride@gmail.com'])->get();

        foreach ($roles as $role) {

            $permissions = $role['permissions'] ?? [];
            $name =  $role['name'] ;
            $guard =  $role['guard_name'] ;

            unset($role['permissions']);



            $role =  Role::updateOrCreate(
                            [
                                "name" => $name,
                                "guard_name" =>  $guard,
                            ],
                            $role
                    );
            // echo __("[$guard] Role : :name => Ok!\n",['name' => $role->name]);


            echo __("All Roles & Permissions Created. \n\n");

            if ($permissions and $role instanceof Role){
                $role->syncPermissions($permissions);
                echo(__(":count permission(s) synchronisée(s)",['count' => $role->permissions->count()]));

                if (filled($users)){
                    $users->map->assignRole($role);
//                    foreach ($users as $resource) {
//                        if ($resource and !$resource->hasRole($role)) {
//                            $resource->assignRole($role);
//                        }
//                    }
                }

            }

        }

        $this->command->alert(strtoupper("[END] Roles"));
    }
}
