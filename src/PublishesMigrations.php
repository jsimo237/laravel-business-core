<?php

namespace Kirago\BusinessCore;

use Generator;
use Illuminate\Support\Str;

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
            $generator = function(string $directory): Generator {
                foreach ($this->app->make('files')->allFiles($directory) as $file) {
                    yield $file->getPathname() => $this->app->databasePath(
                        'migrations/' . now()->format('Y_m_d_His') . Str::after($file->getFilename(), '00_00_00_000000')
                    );
                }
            };

            $this->publishes(iterator_to_array($generator($directory)), 'business-core-migrations');
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