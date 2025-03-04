<?php

namespace Kirago\BusinessCore\Commands\Install;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstallDBCommand extends Command
{
    protected $signature = 'bc:install-db';
    protected $description = "Install all tables in the database";

    public function handle()
    {
        // Désactiver les contraintes de clé étrangère temporairement
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        // Demander à l'utilisateur s'il veut publier les migrations
        if ($this->confirm("Voulez-vous publier les fichiers de migration ?", false)) {
            // Publier les migrations du package
            Artisan::call("vendor:publish", [
                "--tag" => "business-core-migrations"
            ]);

            $this->info("Les migrations ont été publiées.");

            // Exécuter les migrations depuis le dossier de l'application
            Artisan::call("migrate:fresh", ['--force' => true]);
        } else {
            // Exécuter les migrations directement depuis les modules du package
            $this->runPackageMigrations();
        }

       // $this->info(strtoupper("Toutes les tables ont été créées dans la base de données"));


        return self::SUCCESS;
    }

}
