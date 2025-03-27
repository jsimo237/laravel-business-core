<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;


use Illuminate\Database\Eloquent\Relations\HasOne;
use Kirago\BusinessCore\Database\Factories\OrganizationManagement\CustomerFactory;
use Kirago\BusinessCore\Database\Factories\OrganizationManagement\StaffFactory;
use Kirago\BusinessCore\Modules\MediableBcModel;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;
use Illuminate\Notifications\Notifiable;


/**
 * @property string|int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
class BcStaff extends MediableBcModel implements AuthenticatableModelContract {

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

    public function getGuardName(): string
    {
        return "staff";
    }

    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
