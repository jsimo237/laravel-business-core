<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Kirago\BusinessCore\Modules\MediableBcModel;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;
use Kirago\BusinessCore\Support\Bootables\Personnable;

/**
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
abstract class BaseBcCustomer extends MediableBcModel
    implements AuthenticatableModelContract {

    use HasUser;

    //FUNCTIONS

   /************ Abstract functions ************/
    abstract public static function getAuthIdentifiersFields() : array;
    abstract public function getGuardName() : string;


    //
    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
