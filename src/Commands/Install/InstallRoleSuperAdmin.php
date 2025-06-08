<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InstallRoleSuperAdmin extends Command{

    protected $signature = 'bc:install.role-super-admin';

    protected $description = "";

    public function handle(){

        DB::beginTransaction();
        try {

            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            $role = [
                'name' => Role::SUPER_ADMIN,
                'editable' => false,
                'description' => null,
                'guard_name' => "api",
                'organization_id' =>  null,
            ];

            /**
             * @var Role $role
             */
           $role = Role::upsert($role,['name']);

         //  $role->givePermissionTo(Permission::pluck('id')->toArray());

            $this->info("✅  Le rôle Super-Admin a été créé.");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error during {$this->signature}  : " . $e->getMessage());
        }

    }
}
