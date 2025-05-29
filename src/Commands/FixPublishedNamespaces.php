<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixPublishedNamespaces extends Command
{
    protected $signature = 'bc:fix-namespaces';
    protected $description = 'Corrige les namespaces et les imports use des fichiers PHP publiés dans app/Modules, app/Support, app/JsonApi, etc.';

    public function handle()
    {
        $targets = [
            app_path('Modules')  => ['from' => 'Kirago\\BusinessCore\\Modules', 'to' => 'App\\Modules'],
            app_path('Support')  => ['from' => 'Kirago\\BusinessCore\\Support', 'to' => 'App\\Support'],
            app_path('JsonApi')  => ['from' => 'Kirago\\BusinessCore\\JsonApi', 'to' => 'App\\JsonApi'],

            config_path('business-core.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('eloquent-authorable.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('jsonapi.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('media-library.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('notification-manager.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('permission.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('auth.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('activitylog.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
            config_path('bc-data/permissions.php') => ['from' => 'Kirago\\BusinessCore', 'to' => 'App'],
        ];

        $totalFixed = 0;

        foreach ($targets as $basePath => $ns) {
            if (is_dir($basePath)) {
                $files = File::allFiles($basePath);
            } elseif (is_file($basePath)) {
                $files = [new \SplFileInfo($basePath)];
            } else {
                continue;
            }

            $from = $ns['from'];
            $to = $ns['to'];

            $count = 0;

            foreach ($files as $file) {
                if (!in_array($file->getExtension(), ['php', 'blade.php', 'stub', 'json', 'js', 'ts'])) continue;

                $path = $file->getRealPath();
                $content = File::get($path);
                $updated = false;

                // Remplacer les namespaces déclarés
                $namespacePattern = '/^namespace\s+' . preg_quote($from, '/') . '(.*);/m';
                $namespaceReplacement = 'namespace ' . $to . '$1;';
                if (preg_match($namespacePattern, $content)) {
                    $content = preg_replace($namespacePattern, $namespaceReplacement, $content);
                    $updated = true;
                }

                // Remplacer les imports use
                $usePattern = '/^use\s+(Kirago\\\\BusinessCore\\\\[^\s;]+);/m';
                $content = preg_replace_callback($usePattern, function ($matches) {
                    $fullUse = $matches[1];
                    return 'use ' . $this->replaceNamespace($fullUse) . ';';
                }, $content, -1, $replacedCount1);
                if ($replacedCount1 > 0) {
                    $updated = true;
                }

                // Remplacer les usages inline (hors "use" ou "namespace")
                $inlinePattern = '/Kirago\\\\BusinessCore\\\\[A-Za-z0-9_\\\\]+/';
                $content = preg_replace_callback(
                                $inlinePattern,
                                fn ($matches)=> $this->replaceNamespace($matches[0]),
                                $content, -1, $replacedCount2
                            );
                if ($replacedCount2 > 0) {
                    $updated = true;
                }

                if ($updated) {
                    File::put($path, $content);
                    $this->info("✅ Corrigé : {$file->getRelativePathname()}");
                    $count++;
                }
            }

            $this->line("📂 $count fichier(s) corrigé(s) dans $basePath");
            $totalFixed += $count;
        }

        if ($totalFixed === 0) {
            $this->warn("❗ Aucun namespace ou import à corriger.");
        } else {
            $this->info("🎉 Total : $totalFixed fichier(s) corrigé(s).");
        }

        return Command::SUCCESS;
    }

    protected function replaceNamespace(string $input): string
    {
        $replacements = [
            'Kirago\\BusinessCore\\Modules' => 'App\\Modules',
            'Kirago\\BusinessCore\\Support' => 'App\\Support',
            'Kirago\\BusinessCore\\JsonApi' => 'App\\JsonApi',
            'Kirago\\BusinessCore' => 'App',
        ];

        foreach ($replacements as $from => $to) {
            if (str_starts_with($input, $from)) {
                return str_replace($from, $to, $input);
            }
        }

        return $input;
    }
}
