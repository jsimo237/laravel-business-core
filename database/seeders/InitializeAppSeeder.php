<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitializeAppSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $this->call([
            GateSeeder::class,
            StatusSeeder::class,
            PaymentMethodSeeder::class,
        ]);

    }
}
