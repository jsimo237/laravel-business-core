<?php

namespace Kirago\BusinessCore;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;



class BusinessCoreManager
{

    /**
     * Découvre et enregistre toutes les routes (web + api)
     */
    public function discoverRoutes(?string $prefix = null): void
    {
        $this->discoverWebRoutes($prefix);
        $this->discoverApiRoutes($prefix);
    }

    /**
     * Découvre uniquement les routes web (nommées `web.php`)
     */
    public function discoverWebRoutes(?string $prefix = null): void
    {
        $webRoutes = $this->getRouteFilesMatching('web.php');

        foreach ($webRoutes as $file) {
            Route::middleware('web')
                ->prefix(filled($prefix) ? $prefix : "")
                ->group($file);
        }
    }

    /**
     * Découvre uniquement les routes API (nommées `api.php`)
     */
    public function discoverApiRoutes(?string $prefix = null): void
    {
        $apiRoutes = $this->getRouteFilesMatching('api.php');

        foreach ($apiRoutes as $file) {
            Route::middleware('api')
                ->prefix(filled($prefix) ? "api/$prefix" : "api")
                ->group($file);
        }
    }

    /**
     * Retourne tous les fichiers routes correspondant à un nom donné (ex: api.php ou web.php)
     */
    protected function getRouteFilesMatching(string $fileName): array
    {
        $configuredPath = config('business-core.modules_path',null);

        $basePath = $configuredPath
                    ? base_path($configuredPath)
                    : __DIR__ . '/Modules';

        $iterator = null;

        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($basePath)
            );
        }catch (\Exception $exception){

        }

        $result = [];

          if ($iterator){
              foreach ($iterator as $file) {
                  if ($file->isFile() && $file->getFilename() === $fileName) {
                      // Optionnel : filtrer pour s'assurer que le fichier est bien dans un dossier "Routes"
                      if (Str::contains($file->getPath(), 'Routes')) {
                          $result[] = $file->getRealPath();
                      }
                  }
              }
          }

        return $result;
    }

    protected function getRouteFiles(string $directory): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($directory)
                    );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getPathInfo()->getFilename() === 'Routes') {
                $files[] = $file->getRealPath();
            }
        }

        return $files;
    }
}