<?php

namespace Kirago\BusinessCore;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;



class BcRouteManager
{

    /**
     * Découvre et enregistre toutes les routes (web + api)
     */
    public function discover(): void
    {
        $this->discoverWeb();
        $this->discoverApi();
    }

    /**
     * Découvre uniquement les routes web (nommées `web.php`)
     */
    public function discoverWeb(): void
    {
        $webRoutes = $this->getRouteFilesMatching('web.php');

        foreach ($webRoutes as $file) {
            Route::middleware('web')->group($file);
        }
    }

    /**
     * Découvre uniquement les routes API (nommées `api.php`)
     */
    public function discoverApi(): void
    {
        $apiRoutes = $this->getRouteFilesMatching('api.php');

        foreach ($apiRoutes as $file) {
            Route::prefix('api')->middleware('api')->group($file);
        }
    }

    /**
     * Retourne tous les fichiers routes correspondant à un nom donné (ex: api.php ou web.php)
     */
    protected function getRouteFilesMatching(string $fileName): array
    {
        $basePath = __DIR__ . '/Modules';

        $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($basePath)
            );

        $result = [];

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getFilename() === $fileName) {
                // Optionnel : filtrer pour s'assurer que le fichier est bien dans un dossier "Routes"
                if (Str::contains($file->getPath(), 'Routes')) {
                    $result[] = $file->getRealPath();
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