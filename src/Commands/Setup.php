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

        // Demander à l'utilisateur s'il veut publier les migrations
        if ($this->confirm("dou you want to generate and publish migration files ?", false)) {
            // Publier les migrations du package
            Artisan::call("vendor:publish", [
                "--tag" => "bc-migrations"
            ]);

            $this->info("✅ Migrations files published.");

            // Exécuter les migrations depuis le dossier de l'application
            Artisan::call("migrate:fresh", ['--force' => true]);
        } else {

            Artisan::call("migrate:fresh", ['--force' => true]);

            // Exécuter les migrations directement depuis les modules du package
          //  $this->runPackageMigrations();
        }

        // Créee les permissions
       // Artisan::call("bc:install/permissions");
       // $this->info("✅ All Permissions Data created in database");

        $this->info("✅ Business Core Database stucture setting up!");


        return self::SUCCESS;
    }

}
