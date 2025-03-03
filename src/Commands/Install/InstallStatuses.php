<?php


namespace Kirago\BusinessCore\Commands\Install;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;


class InstallStatuses extends Command{

    protected $signature = 'bc:install-statuses';

    protected $description = "";

    public function handle(){


        $rows = config("bc-data.statuses");

        try {
            Status::upsert($rows, ['code']);
            $this->info('Toutes les statuses ont été installées');
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'installation des statuts : ' . $e->getMessage());
        }

    }
}
