<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Kirago\BusinessCore\Data\CommissionTypeData;
use Kirago\BusinessCore\Models\CommissionManagement\CommissionType;
use Illuminate\Database\Seeder;


class CommissionTypeSeeder extends Seeder{

    public function run(){

        echo(strtoupper("[BEGIN] Commissions Type \n"));
        $rows =  CommissionTypeData::items();

        if ($rows ){
            CommissionType::upsert($rows,['code']);
        }
    }
}
