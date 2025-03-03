<?php


namespace Kirago\BusinessCore\Commands\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Database\Seeders\CommissionTypeSeeder;
use Kirago\BusinessCore\Database\Seeders\GateSeeder;
use Kirago\BusinessCore\Database\Seeders\StatusSeeder;


class InstallDBCommand extends Command{

    protected $signature = 'business-core:install-db';
    protected $description = "";

    public function handle(){

        DB::unprepared("set foreign_key_checks=0");

        Artisan::call("migrate:fresh");
        echo strtoupper("All Tables created in database.\n\n");

        $seeds = [
            GateSeeder::class,
            CommissionTypeSeeder::class,
            StatusSeeder::class,
        ];

        if ($seeds){
            foreach ($seeds as $seed) {
                Artisan::call("db:seed" , ['--class' => $seed ]);
            }
        }

        echo strtoupper("All Data installed in Database \n\n");

    }
}
