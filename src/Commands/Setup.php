<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Setup extends Command
{
    protected $signature = 'bc:setup';
    protected $description = "Install all tables in the database";

    public function handle()
    {

        // Désactiver les contraintes de clé étrangère temporairement
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        if ($this->confirm("Dou you want to publish config files ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-config" ]);
            $this->info("✅  config/business-core.php published.");
        }
        if ($this->confirm("Dou you want to publish all data files ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-data" ]);
            $this->info("✅ Published! You can see directory config/bc-data .");
        }

        // Demander à l'utilisateur s'il veut publier les migrations
        if ($this->confirm("Dou you want to generate and publish migration files ?", true)) {
            Artisan::call("vendor:publish", [  "--tag" => "bc-migrations" ]);
            $this->info("✅  Migrations files published.");

        } else {

            // Exécuter les migrations directement depuis les modules du package
          //  $this->runPackageMigrations();
        }

        //Artisan::call("config:clear");
        //Artisan::call("config:cache");
        //Artisan::call("optimize:clear");

        // Exécuter les migrations depuis le dossier de l'application
        Artisan::call("migrate:fresh", ['--force' => true]);

        Artisan::call("bc:install.role-super-admin");
        $this->info("✅ Role Super-Admin created .");

        Artisan::call("bc:install.permissions");
        $this->info("✅ All Permissions data created .");




        Artisan::call("optimize:clear");
        // Créee les permissions
       // Artisan::call("bc:install/permissions");
       // $this->info("✅ All Permissions Data created in database");

        $this->info("✅  Business Core Database stucture setting up!");


        return self::SUCCESS;
    }

}
