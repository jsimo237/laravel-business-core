<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class PublishCoreFolders extends  Command
{

    protected $signature = 'bc:publish-core-folders';
    protected $description = 'Publie les dossiers Modules, Support et JsonApi depuis le package vers app/, puis corrige les namespaces dans les fichiers';

    public function handle()
    {
        if (config("business-core.customization",false) === false) {
            $this->warn("Veuillez activer la customisation dans 'config/business-core.php' !");
           return Command::SUCCESS;

        }

        $base = base_path('vendor/kirago/laravel-business-core/src'); // adapt if needed
        $targets = [
            'Modules' => app_path('Modules'),
            'Support' => app_path('Support'),
            'JsonApi' => app_path('JsonApi'),
        ];

        foreach ($targets as $sourceFolder => $destinationPath) {
            $sourcePath = $base . '/' . $sourceFolder;

            if (!is_dir($sourcePath)) {
                $this->warn("❌ Source non trouvée : $sourcePath");
                continue;
            }

            // Crée le dossier destination s’il n’existe pas
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
                $this->info("📁 Dossier créé : $destinationPath");
            }

            // Copie le dossier complet
            File::copyDirectory($sourcePath, $destinationPath);
            $this->info("✅ Fichiers copiés de $sourceFolder vers $destinationPath");
        }

        // Appelle la commande bc:fix-namespaces après copie
        try {
            $this->call('bc:fix-namespaces');
            $this->call("vendor:publish", [ "--tag" => "bc-resources-views" ]);

              if ($this->confirm("Publier le Handler pour la gestion des exception ?", true)) {
                  $this->call("bc:patch-handler");
             }

            $this->info("✅  all views files published in 'views/vendor/business-core' ");
        } catch (CommandNotFoundException $e) {
            $this->error('❌ La commande "bc:fix-namespaces" est introuvable. Assure-toi qu’elle est bien déclarée.');
        }
        $this->info("✅ Published! You can customize JsonApi,Models and more .");
        return Command::SUCCESS;
    }
}