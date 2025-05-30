<?php

namespace Kirago\BusinessCore\Helpers;

use Illuminate\View\Component;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use ReflectionClass;

final class ViewComponentProviderHelper
{
    /**
     * Découvre récursivement les dossiers "View/Components" dans les modules.
     * Retourne un tableau de chemins complets vers les fichiers PHP de composants Blade.
     * @return string[]
     */
    public static function discoverComponentFilesFromModules(): array
    {
        $customization = config('business-core.customization',false);
        $baseDir = $customization
                    ? base_path("app/Modules")
                    : realpath(__DIR__ . '/../Modules'); // Fallback vers le package

        if (!$baseDir || !is_dir($baseDir)) {
            return [];
        }

        $componentFiles = [];

        try {
            $directoryIterator = new RecursiveDirectoryIterator(
                                    $baseDir,
                                    FilesystemIterator::SKIP_DOTS
                                );

            $iterator = new RecursiveIteratorIterator(
                            $directoryIterator,
                            RecursiveIteratorIterator::SELF_FIRST
                        );

        } catch (\Exception $e) {
            report($e);
            return [];
        }

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()
                && $fileInfo->getExtension() === 'php'
                && str_contains($fileInfo->getPath(), DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'Components')
            ) {
                $componentFiles[] = $fileInfo->getRealPath();
            }
        }

        return array_unique($componentFiles);
    }

    /**
     * Extrait le namespace complet (FQCN) d'une classe à partir de son fichier.
     * @param string $file
     * @return string|null
     */
    public static function getFullyQualifiedClassName(string $file): ?string
    {
        $contents = file_get_contents($file);

        $namespace = null;
        if (preg_match('/^namespace\s+(.+?);/m', $contents, $matches)) {
            $namespace = trim($matches[1]);
        }

        if (preg_match('/^class\s+(\w+)/m', $contents, $matches)) {
            $class = trim($matches[1]);
            return $namespace ? $namespace . '\\' . $class : $class;
        }

        return null;
    }

    /**
     * Retourne la liste des classes composants Blade découvertes et valides.
     * @return string[] liste des FQCN
     */
    public static function getValidBladeComponents(): array
    {
        $files = self::discoverComponentFilesFromModules();
        $components = [];

        foreach ($files as $file) {
            $class = self::getFullyQualifiedClassName($file);

            if (!$class || !class_exists($class)) {
                continue;
            }

            try {
                $ref = new ReflectionClass($class);
                if ($ref->isSubclassOf(Component::class) && !$ref->isAbstract()) {
                    $components[] = $class;
                }
            } catch (\ReflectionException $e) {
                // ignore classes non-autoloadables
                continue;
            }
        }

        return array_unique($components);
    }
}