<?php
namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Seeder;
use Kirago\BusinessCore\Data\CurrencyData;
use Kirago\BusinessCore\Modules\SettingManagment\Currency;

class CurrencySeeder extends Seeder {
    /**
     * @return void
     */
    public function run(){
        $currencies = CurrencyData::items();


        collect($currencies)->map(function($currency) {
            factory(Currency::class)->create($currency);
        });
    }
}
