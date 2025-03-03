<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Kirago\BusinessCore\Models\WalletManagement\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        Wallet::factory(10)->create();
    }
}
