<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;


class InstallRoleSuperAdmin extends Command{

    protected $signature = 'bc:install.role-super-admin';

    protected $description = "";

    public function handle(){

        DB::beginTransaction();
        try {

            $role = [
                'name' => BcRole::SUPER_ADMIN,
                'editable' => false,
                'description' => null,
                'guard_name' => "api",
                'organization_id' =>  null,
            ];

            /**
             * @var BcRole $role
             */
           $role = BcRole::upsert($role,['name']);

           echo ((new  BcRole)->getTable());

         //  $role->givePermissionTo(BcPermission::pluck('id')->toArray());

            $this->info('Role Super-Admin has been created!');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Error during {$this->signature}  : " . $e->getMessage());
        }

    }
}
