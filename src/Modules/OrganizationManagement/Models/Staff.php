<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Kirago\BusinessCore\Modules\MediableModel;
use Kirago\BusinessCore\Modules\OrganizationManagement\Factories\StaffFactory;
use Kirago\BusinessCore\Modules\SecurityManagement\Interfaces\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;


/**
 * @property string|int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
class Staff extends MediableModel implements AuthenticatableModelContract {

    use HasUser,Notifiable;

    protected $table = "organization_mgt__staffs";

    //RELATIONS
    protected static function newFactory(){
        return StaffFactory::new();
    }

    //FUNCTIONS


    public static function getAuthIdentifiersFields(): array
    {
        return ["email","username"];
    }

    public function guardName(): string
    {
        return "api";
    }

    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
