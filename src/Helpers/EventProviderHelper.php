<?php

namespace Kirago\BusinessCore\Helpers;

final class EventProviderHelper
{

    /**
     * Pour Laravel 9/10 : Middleware registration classique.
     */
    public static function discoverListenerPathsFromModules(): array
    {
        $customization = config('business-core.customization',false);
        $baseDir = $customization
                    ? base_path("app/Modules")
                    : realpath(__DIR__ . '/../Modules'); // Fallback vers le package

        if (!$baseDir || !is_dir($baseDir)) {
            return [];
        }

        $listenerPaths = [];
        $iterator = null;

        try {
            $directoryIterator = new \RecursiveDirectoryIterator(
                $baseDir,
                \FilesystemIterator::SKIP_DOTS
            );

            $iterator = new \RecursiveIteratorIterator(
                $directoryIterator,
                \RecursiveIteratorIterator::SELF_FIRST
            );

        } catch (\Exception $e) {
            report($e); // ou log()->error($e->getMessage());

        } finally {
            if ($iterator) {
                foreach ($iterator as $fileInfo) {
                    if ($fileInfo->isDir() && $fileInfo->getFilename() === 'Listeners') {
                        $listenerPaths[] = $fileInfo->getPathname();
                    }
                }
            }
        }

        return array_unique($listenerPaths);
    }

    /**
     * Méthode pour trouver le FQCN d'un listener :
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

    public static function getEventHandledByListener(string $file): ?string
    {
        $contents = file_get_contents($file);

        // Récupérer les "use" (avec alias éventuels)
        preg_match_all('/use\s+([\w\\\\]+)(\s+as\s+(\w+))?;/', $contents, $useMatches, PREG_SET_ORDER);
        $uses = [];
        foreach ($useMatches as $use) {
            $full = $use[1];
            $alias = $use[3] ?? basename(str_replace('\\', '/', $full));
            $uses[$alias] = $full;
        }

        // Extraire la classe du fichier
        if (preg_match('/namespace\s+([^;]+);/', $contents, $nsMatch)) {
            $namespace = trim($nsMatch[1]);
        } else {
            $namespace = null;
        }

        // Extraire le type du paramètre $event dans handle()
        if (preg_match('/function\s+handle\s*\(\s*(\??\s*[\w\\\\]+)\s+\$event/', $contents, $matches)) {
            $rawType = trim($matches[1], '\\');

            // Résolution via les "use"
            if (isset($uses[$rawType])) {
                return $uses[$rawType];
            }

            // Si c'est un nom FQCN (avec backslashes)
            if (str_contains($rawType, '\\')) {
                return $rawType;
            }

            // Sinon, on suppose qu’il est dans le même namespace
            if ($namespace) {
                return $namespace . '\\' . $rawType;
            }

            // Fallback
            return $rawType;
        }

        return null;
    }


}