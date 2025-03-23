<?php

namespace Kirago\BusinessCore\Support\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

final class BcMigrationPublisher
{

    public static function pus(){

    }


    /**
     * Exécute les migrations des modules du package
     */
    public static function runPackageMigrations()
    {
        // Chemin de base du package
        $packageBasePath = realpath(__DIR__ . '/../../Modules');

        // Vérifier si le dossier des modules existe
        if (!$packageBasePath || !File::exists($packageBasePath)) {
            echo("Le dossier des modules n'existe pas. \n");
            return;
        }

        // Récupérer tous les dossiers des modules
        $modules = File::directories($packageBasePath);

        foreach ($modules as $modulePath) {
            $migrationPath = realpath($modulePath . '/Database/Migrations');

            if ($migrationPath && File::exists($migrationPath)) {
                // Récupérer tous les fichiers de migration du module
                $migrationFiles = File::files($migrationPath);

                if (empty($migrationFiles)) {
                    echo("Aucune migration trouvée pour : " . basename($modulePath));
                    continue;
                }

                foreach ($migrationFiles as $file) {
                    // Générer le chemin relatif du fichier de migration
                    $relativePath = str_replace(realpath(base_path()), '', $file->getRealPath());
                    $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');

                    echo("Exécution de la migration : " . basename($relativePath)."\n");

                    // Exécuter la migration pour chaque fichier
                    Artisan::call('migrate', ['--path' => $relativePath, '--force' => true]);
                }
            }
        }
    }


}