<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::beginTransaction();
        try {
            User::factory(2)->create();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
        }
    }
}
