<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class InstallPermissions extends Command{

    protected $signature = 'bc:install.permissions';

    protected $description = "";

    public function handle(){

        $rows = config("bc-data.permissions");

        try {
            // Rest cached roles and permissions
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            Permission::upsert($rows, ['name',"guard_name"]);

            Permission::syncAllPermissionsToSuperAdminRole();

            $this->info("✅  Les permissions ont été créées.");
        } catch (\Exception $e) {
            $this->error("Error during {$this->signature}  : " . $e->getMessage());
        }

    }
}
