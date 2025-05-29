<?php

namespace Kirago\BusinessCore\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ClearEventsCache extends Command
{
    protected $signature = 'bc:clear-event-cache';
    protected $description = 'Effacer le cache des événements et de leurs listeners pour les modules BusinessCore';

    public function handle()
    {
        $this->info('Analyse des listeners…');

        $path = storage_path('framework/cache/business-core/events.php');

        if (file_exists($path)) {
            unlink($path);
            $this->info("Cache des événements supprimé.");
        } else {
            $this->warn("Aucun cache trouvé.");
        }
    }

}
