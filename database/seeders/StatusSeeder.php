<?php

namespace Kirago\BusinessCore\Database\Seeders;


use Illuminate\Database\Seeder;
use Kirago\BusinessCore\Data\StatusData;
use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;

class StatusSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $statuses = StatusData::items();
        $this->command->alert(strtoupper("[BEGIN] Payment transactions statuses"));
        $this->command->info(__(":count élément(s) détecté(s)!",["count" => count($statuses)]));
        if($statuses){
            foreach($statuses as $status) {
                $code = $status['code'];
                //unset($status['code'],$status['position']);
                Status::firstOrCreate(
                    [ "code" => $code ],
                    $status
                );
                $this->command->info(__(":name ===> OK!!",["name" => $status['name']]));
            }
        }
        $this->command->alert(strtoupper("[END] Payment transactions statuses"));
    }
}
