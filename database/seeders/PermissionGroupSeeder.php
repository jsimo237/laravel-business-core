<?php

namespace Kirago\BusinessCore\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\PermissionGroup;

class PermissionGroupSeeder extends Seeder{

    public function run(){
        $this->command->alert(strtoupper("[BEGIN] Permissions groups"));

        $groups = [
            ["id" => PermissionGroup::ROLE, "name" => "Rôle",],
            ["id" => PermissionGroup::USER, "name" => "Utilisateur",],
            ["id" => PermissionGroup::ORGANISER, "name" => "Organisateur",],
            ["id" => PermissionGroup::ELECTOR, "name" => "Electeur",],
            ["id" => PermissionGroup::ATTENDEE, "name" => "Participant",],
            ["id" => PermissionGroup::VOTE, "name" => "Vote",],
            ["id" => PermissionGroup::SETTING, "name" => "Paramètre",],
            ["id" => PermissionGroup::ACCOUNT, "name" => "Compte",],
            ["id" => PermissionGroup::COUNTRY, "name" => "Pays",],
        ];


        $this->command->info(__("Groups (:count)",['count' => count($groups)]));
        collect($groups)->map(function ($group){
            $g = PermissionGroup::where('name',$group['name'])->first();

            if (blank($g)){
                PermissionGroup::create($group);
                $this->command->info(__(":name created",['name' => $group['name']]));
            }else{
                $g->update($group);
                $this->command->info(__(":name updated",['name' => $group['name']]));
            }
        });
        $this->command->alert(strtoupper("[END] Permissions groups"));
    }
}
