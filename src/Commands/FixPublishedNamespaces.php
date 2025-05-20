<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixPublishedNamespaces extends Command
{
    protected $signature = 'bc:fix-namespaces';
    protected $description = 'Corrige les namespaces et les imports use des fichiers PHP publiés dans app/Modules, app/Support et app/JsonApi';

    public function handle()
    {
        $targets = [
            app_path('Modules')  => ['from' => 'Kirago\\BusinessCore\\Modules', 'to' => 'App\\Modules'],
            app_path('Support')  => ['from' => 'Kirago\\BusinessCore\\Support', 'to' => 'App\\Support'],
            app_path('JsonApi')  => ['from' => 'Kirago\\BusinessCore\\JsonApi', 'to' => 'App\\JsonApi'],
        ];

        $totalFixed = 0;

        foreach ($targets as $basePath => $ns) {
            if (!is_dir($basePath)) {
                File::makeDirectory($basePath, 0755, true);
                $this->info("📁 Dossier créé : $basePath");
            }

            $from = $ns['from'];
            $to = $ns['to'];

            $namespacePattern = '/^namespace\s+' . preg_quote($from, '/') . '(.*);/m';
            $namespaceReplacement = 'namespace ' . $to . '$1;';

            // Ce pattern attrape tous les "use Kirago\BusinessCore\..." sur une ligne
            $usePattern = '/^use\s+(Kirago\\\\BusinessCore\\\\[^\s;]+);/m';

            $files = collect(File::files($basePath))->merge(File::allFiles($basePath));

            $count = 0;

            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') continue;

                $path = $file->getRealPath();
                $content = File::get($path);
                $updated = false;

                // Correction du namespace principal
                if (preg_match($namespacePattern, $content)) {
                    $content = preg_replace($namespacePattern, $namespaceReplacement, $content);
                    $updated = true;
                }

                // Correction des imports `use`
                $content = preg_replace_callback($usePattern, function ($matches) {
                    $fullUse = $matches[1];

                    // Remplace les namespaces Modules, Support ou JsonApi
                    $replacements = [
                        'Kirago\\BusinessCore\\Modules' => 'App\\Modules',
                        'Kirago\\BusinessCore\\Support' => 'App\\Support',
                        'Kirago\\BusinessCore\\JsonApi' => 'App\\JsonApi',
                    ];

                    foreach ($replacements as $from => $to) {
                        if (str_starts_with($fullUse, $from)) {
                            return 'use ' . str_replace($from, $to, $fullUse) . ';';
                        }
                    }

                    return $matches[0]; // aucun remplacement
                }, $content, -1, $replacedCount);

                if ($replacedCount > 0) {
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
}
