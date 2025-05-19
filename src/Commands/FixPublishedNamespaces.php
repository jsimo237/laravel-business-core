<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixPublishedNamespaces extends Command
{
    protected $signature = 'bc:fix-namespaces';
    protected $description = 'Corrige les namespaces des fichiers PHP publiés dans app/Modules, app/Support et app/JsonApi';

    public function handle()
    {
        // Définir les cibles avec le mapping correct pour chaque dossier.
        $targets = [
            app_path('Modules')  => ['from' => 'Kirago\\BusinessCore\\Modules', 'to' => 'App\\Modules'],
            app_path('Support')  => ['from' => 'Kirago\\BusinessCore\\Support', 'to' => 'App\\Support'],
            app_path('JsonApi')  => ['from' => 'Kirago\\BusinessCore\\JsonApi', 'to' => 'App\\JsonApi'],
        ];

        $totalFixed = 0;

        foreach ($targets as $basePath => $namespaces) {
            if (!is_dir($basePath)) {
                $this->warn("❌ Dossier introuvable : $basePath");
                continue;
            }

            // Définir le pattern qui ne vise que la ligne du namespace
            $pattern = '/^namespace\s+' . preg_quote($namespaces['from'], '/') . '(.*);/m';
            $replacement = 'namespace ' . $namespaces['to'] . '$1;';

            // Récupère d'abord les fichiers à la racine du dossier
            $files = collect(File::files($basePath));
            // Puis merge avec tous les fichiers contenus dans les sous-dossiers
            $files = $files->merge(File::allFiles($basePath));

            $count = 0;

            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $path = $file->getRealPath();
                $content = File::get($path);

                // Vérifie si la ligne namespace correspond
                if (!preg_match($pattern, $content)) {
                    continue;
                }

                $newContent = preg_replace($pattern, $replacement, $content);
                File::put($path, $newContent);
                $this->info("✅ Corrigé : {$file->getRelativePathname()}");
                $count++;
            }

            $this->line("📂 $count fichier(s) corrigé(s) dans $basePath");
            $totalFixed += $count;
        }

        if ($totalFixed === 0) {
            $this->warn("❗ Aucun namespace à corriger.");
        } else {
            $this->info("🎉 Total : $totalFixed fichier(s) corrigé(s).");
        }

        return Command::SUCCESS;
    }
}
