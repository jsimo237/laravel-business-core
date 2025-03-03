<?php

namespace Kirago\BusinessCore;

use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Media;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Modules\SettingManagment\Notification;


abstract class MorphMap {

    public static function get(){
        return [
            "status-change" => StatusChange::class,
            "status" => Status::class,

            //polymorphs
            "media" =>  Media::class,
            //  "comment" => Comment::class,
            "notification" => Notification::class,

            //Gate
            "role" => Role::class,
            "permission" => Permission::class,

            //localize
            "country" => Country::class,
            "state" => State::class,
            "city" => City::class,
            "quarter" => Quarter::class,

            //
            "user" => User::class,
        ];
    }
}