<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission;
use Spatie\Permission\PermissionRegistrar;


class InstallPermissions extends Command{

    protected $signature = 'bc:install.permissions';

    protected $description = "";

    public function handle(){

        $rows = config("bc-data.permissions");

        try {
            // Rest cached roles and permissions
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            BcPermission::upsert($rows, ['name',"guard_name"]);

            $this->info('Toutes les permissions ont été installées');
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'installation des permissions : " . $e->getMessage());
        }

    }
}
