<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PatchHandlerCommand extends Command
{
    protected $signature = 'bc:patch-handler';
    protected $description = 'Met à jour le Handler d’exception avec les améliorations de BusinessCore';

    public function handle()
    {
        $filesystem = new Filesystem();
        $targetPath = app_path('Exceptions/Handler.php');
        $sourcePath = __DIR__ . '/../Exceptions/Handler.php';

        // Si le fichier cible n'existe pas, on crée le dossier et on copie le fichier source
        if (!$filesystem->exists($targetPath)) {
            $filesystem->ensureDirectoryExists(dirname($targetPath));

            if (!$filesystem->exists($sourcePath)) {
                $this->error("Le fichier source Handler.php est introuvable à : {$sourcePath}");
                return;
            }

            $filesystem->copy($sourcePath, $targetPath);
            $this->info("Handler.php introuvable. Fichier copié depuis BusinessCore.");
            return;
        }

        // Lecture du contenu actuel
        $content = $filesystem->get($targetPath);

        // 1. Ajouter JsonApiException dans $dontReport
        if (!str_contains($content, 'JsonApiException::class')) {
            $content = preg_replace_callback(
                '/protected \$dontReport\s*=\s*\[(.*?)\];/s',
                function ($matches) {
                    $list = trim($matches[1]);
                    if (!str_ends_with($list, ',')) {
                        $list .= ',';
                    }
                    $list .= "\n        \\Neomerx\\JsonApi\\Exceptions\\JsonApiException::class,";
                    return "protected \$dontReport = [\n{$list}\n    ];";
                },
                $content
            );
        }

        // 2. Ajouter le use de JsonApiException
        if (!str_contains($content, 'use Neomerx\JsonApi\Exceptions\JsonApiException;')) {
            $content = preg_replace(
                '/namespace App\\\Exceptions;\n/',
                "namespace App\Exceptions;\n\nuse Neomerx\\JsonApi\\Exceptions\\JsonApiException;\n",
                $content
            );
        }

        // 3. Ajouter customRegister() si manquante
        if (!str_contains($content, 'function customRegister')) {
            $sourceContent = file_get_contents($sourcePath);
            preg_match('/protected function customRegister\(\).*?\n\s+\}/s', $sourceContent, $match);
            if (isset($match[0])) {
                $content = rtrim($content) . "\n\n    " . $match[0] . "\n";
            }
        }

        // 4. Appeler customRegister() dans register()
        if (!str_contains($content, '$this->customRegister()')) {
            $content = preg_replace(
                '/public function register\(\): void\s*{\s*/',
                "public function register(): void {\n        \$this->customRegister();\n",
                $content
            );
        }

        $filesystem->put($targetPath, $content);
        $this->info("Handler.php mis à jour avec les améliorations BusinessCore.");
    }
}
