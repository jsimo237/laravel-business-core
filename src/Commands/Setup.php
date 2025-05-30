<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Setup extends Command
{
    protected $signature = 'bc:setup';

    protected $description = "Installer toutes les tables du module business-core dans la base de données";

    public function handle()
    {
        // Désactiver temporairement les contraintes de clés étrangères
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        // Publier les fichiers de configuration
        $this->call("vendor:publish", [ "--tag" => "bc-config" ]);
        // $this->info("✅  Le fichier de configuration config/business-core.php a été publié.");

        $this->call("vendor:publish", [ "--tag" => "bc-config-all" ]);
        // $this->info("✅  Tous les autres fichiers de configuration ont été publiés.");

        // Publier les fichiers de données si confirmé
       // if ($this->confirm("Souhaitez-vous publier tous les fichiers de données business-core ?", true)) {
             $this->call("vendor:publish", [ "--tag" => "bc-data" ]);
           // $this->info("✅  Fichiers publiés ! Vous pouvez les retrouver dans le répertoire config/bc-data.");
       // }

        // Publier les fichiers de migrations si confirmé
      //  if ($this->confirm("Souhaitez-vous publier tous les fichiers de migration business-core ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-migrations" ]);
            $this->info("✅  Les fichiers de migration ont été publiés.");
       // }

        // Réinitialiser et recompiler le cache de configuration
        $this->call("config:clear");
        $this->call("config:cache");

        // Exécuter les migrations avec une base propre
        $this->call("migrate:fresh", ['--force' => true]);

        // Installer les devises
        $this->call("bc:install.currencies");

        // Créer le rôle Super Admin
        $this->call("bc:install.role-super-admin");

        // Créer les permissions
        $this->call("bc:install.permissions");

        // Message de fin
        $this->info("✅  Structure de la base de données Business Core configurée avec succès !");

        return self::SUCCESS;
    }
}
