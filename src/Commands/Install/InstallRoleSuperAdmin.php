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
             //   'guard_name' => "api",
            ];

            /**
             * @var BcRole $role
             */
           $role = BcRole::updateOrCreate(['name'=>$role['name']],$role);

         //  $role->givePermissionTo(BcPermission::pluck('id')->toArray());

            $this->info('Le role Super-Admin est crée');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error("Erreu creation role : " . $e->getMessage());
        }

    }
}
