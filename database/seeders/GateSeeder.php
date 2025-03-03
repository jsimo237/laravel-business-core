<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GateSeeder extends Seeder{

    public function run(){

        $this->call([
           //PermissionGroupSeeder::class,
           PermissionSeeder::class,
           RoleSeeder::class,
        ]);
    }
}
