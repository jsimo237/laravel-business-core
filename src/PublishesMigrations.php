<?php

namespace Kirago\BusinessCore;

use Generator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait PublishesMigrations {

    /**
     * Searches migrations and publishes them as assets.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function registerMigrations(string $directory): void{

        if ($this->app->runningInConsole()) {

            $generator = function(string $directory)  : Generator {
                          $subPath = config("business-core.migrations.sub-path");
                            foreach ($this->app->make('files')->allFiles($directory) as $file) {
                                yield $file->getPathname() => $this->app->databasePath(
                                   // 'migrations/' . now()->format('Y_m_d_His') . Str::after($file->getFilename(), '00_00_00_000000')
                                    "migrations/$subPath/{$file->getFilename()}"
                                );
                            }
                        };

            $this->publishes(iterator_to_array($generator($directory)), 'bc-migrations');
        }
    }


    protected function publishModulesMigrations(){
        // Chemin de base du package
        $packageBasePath = realpath(__DIR__."/../database/migrations");
        //$packageBasePath = __DIR__ . '/../Modules';

        // Vérifier si le dossier des modules existe
        if (!$packageBasePath || !File::exists($packageBasePath)) {
            echo("Le dossier des modules n'existe $packageBasePath. \n");
            return;
        }

        // Récupérer tous les dossiers des modules
        $modules = File::directories($packageBasePath);

        foreach ($modules as $modulePath) {
            $migrationPath = $modulePath ;
            //$migrationPath = $modulePath . '/Database/Migrations';

            // Vérifier si le dossier des migrations existe pour ce module
            if (File::exists($migrationPath)) {
                echo("Module : " . $migrationPath."\n");
                $this->loadMigrationsFrom($migrationPath);
            }
        }

    }


    public function publishDataToConfig(){

        // Publier le fichier de données dans le dossier config
        $this->publishes(
                    [ __DIR__.'/../../data/statuses.php' => config_path('bc-data/statuses.php'), ],
                    'config'
                );
    }

}