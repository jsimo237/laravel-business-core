<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Setup extends Command
{
    protected $signature = 'bc:setup';

    protected $description = "Install all business-core tables in the database";

    public function handle()
    {
        // Désactiver les contraintes de clé étrangère temporairement
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

       // if ($this->confirm("Dou you want to publish business-core config file ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-config" ]);
            $this->info("✅  config/business-core.php published.");

            Artisan::call("vendor:publish", [ "--tag" => "bc-config-all" ]);
            $this->info("✅  all orthers configs files published.");
       // }

        if ($this->confirm("Dou you want to publish all business-core data files ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-data" ]);
            $this->info("✅ Published! You can see directory config/bc-data .");
        }
        if ($this->confirm("Dou you want to publish all business-core src files ?", true)) {
           // Artisan::call("vendor:publish", [ "--tag" => "bc-src" ]);
            Artisan::call("bc:publish-core-folders");
          //  Artisan::call("bc:fix-namespaces", []);
            $this->info("✅ Published! You can customize JsonApi,Models and more .");
        }

        // Demander à l'utilisateur s'il veut publier les migrations
        if ($this->confirm("Dou you want to publish all business-core migration files ?", true)) {
            Artisan::call("vendor:publish", [  "--tag" => "bc-migrations" ]);
            Artisan::call("vendor:publish", [  "--tag" => "activitylog-migrations" ]);
            $this->info("✅  Migrations files published.");

        } else {

            // Exécuter les migrations directement depuis les modules du package
          //  $this->runPackageMigrations();
        }

        Artisan::call("config:clear");
        Artisan::call("config:cache");
       // Artisan::call("optimize:clear");

        // Exécuter les migrations depuis le dossier de l'application
        Artisan::call("migrate:fresh", ['--force' => true]);

        Artisan::call("bc:install.currencies");
        $this->info("✅ All Currencies data have been created .");

        Artisan::call("bc:install.role-super-admin");
        $this->info("✅ Role Super-Admin created .");

        Artisan::call("bc:install.permissions");
        $this->info("✅ All Permissions data have been created .");


     //   Artisan::call("optimize:clear");
        // Créee les permissions
       // Artisan::call("bc:install/permissions");
       // $this->info("✅ All Permissions Data created in database");

        $this->info("✅  Business Core Database stucture setting up!");


        return self::SUCCESS;
    }

}
