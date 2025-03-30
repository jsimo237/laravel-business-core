<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcCurrency;
use Spatie\Permission\PermissionRegistrar;


class InstallCurrencies extends Command{

    protected $signature = 'bc:install.currencies';

    protected $description = "";

    public function handle(){

        $rows = config("bc-data.currencies");

        DB::beginTransaction();
        try {

            BcCurrency::upsert($rows, ['code']);

            DB::commit();

            $this->info('All currencies data have been installed!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error during {$this->signature}  : " . $e->getMessage());
        }

    }
}
