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
        Artisan::call("vendor:publish", [ "--tag" => "bc-config" ]);
        $this->info("✅  Le fichier de configuration config/business-core.php a été publié.");

        Artisan::call("vendor:publish", [ "--tag" => "bc-config-all" ]);
        $this->info("✅  Tous les autres fichiers de configuration ont été publiés.");

        // Publier les fichiers de données si confirmé
        if ($this->confirm("Souhaitez-vous publier tous les fichiers de données business-core ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-data" ]);
            $this->info("✅  Fichiers publiés ! Vous pouvez les retrouver dans le répertoire config/bc-data.");
        }

        // Publier les fichiers de migrations si confirmé
        if ($this->confirm("Souhaitez-vous publier tous les fichiers de migration business-core ?", true)) {
            Artisan::call("vendor:publish", [ "--tag" => "bc-migrations" ]);
            $this->info("✅  Les fichiers de migration ont été publiés.");
        }

        // Réinitialiser et recompiler le cache de configuration
        Artisan::call("config:clear");
        Artisan::call("config:cache");

        // Exécuter les migrations avec une base propre
        Artisan::call("migrate:fresh", ['--force' => true]);

        // Installer les devises
        Artisan::call("bc:install.currencies");
        $this->info("✅  Les données des devises ont été créées.");

        // Créer le rôle Super Admin
        Artisan::call("bc:install.role-super-admin");
        $this->info("✅  Le rôle Super-Admin a été créé.");

        // Créer les permissions
        Artisan::call("bc:install.permissions");
        $this->info("✅  Les permissions ont été créées.");

        // Message de fin
        $this->info("✅  Structure de la base de données Business Core configurée avec succès !");

        return self::SUCCESS;
    }
}
