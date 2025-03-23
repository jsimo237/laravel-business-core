<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;


class InstallRoles extends Command{

    protected $signature = 'bc:install.roles';

    protected $description = "";

    public function handle(){

        $rows = config("bc-data.permissions");

        try {

            $this->info('Toutes les permissions ont été installées');
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'installation des permissions : " . $e->getMessage());
        }

    }
}
