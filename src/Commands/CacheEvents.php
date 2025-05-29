<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kirago\BusinessCore\Helpers\EventProviderHelper;

class CacheEvents extends Command
{
    protected $signature = 'bc:cache-events';
    protected $description = 'Génère le cache des événements et de leurs listeners pour les modules BusinessCore';

    public function handle()
    {
        $this->info('Analyse des listeners…');

        $listenerPaths = EventProviderHelper::discoverListenerPathsFromModules();
        $eventsMap = [];

        foreach ($listenerPaths as $path) {
            $phpFiles = File::allFiles($path);

            foreach ($phpFiles as $file) {
                $class = EventProviderHelper::getFullyQualifiedClassName($file->getPathname());

                if ($class && method_exists($class, 'handle')) {
                    $event = EventProviderHelper::getEventHandledByListener($class);
                    if ($event) {
                        $eventsMap[$event][] = $class;
                    }
                }
            }
        }

        $cachePath = storage_path('framework/cache/business-core/events.php');
        File::put($cachePath, '<?php return ' . var_export($eventsMap, true) . ';');

        $this->info("Cache généré avec succès : " . $cachePath);
    }

}
