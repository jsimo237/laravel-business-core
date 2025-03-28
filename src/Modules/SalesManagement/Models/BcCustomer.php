<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;

/**
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string fullname
 * @property string username
 * @property string email
 * @property string phone
 */
class BcCustomer extends BaseBcCustomer implements AuthenticatableModelContract {

    protected $table = "sales_mgt__customers";

    //RELATIONS

    //FUNCTIONS
    public static function getAuthIdentifiersFields(): array
    {
        return ["email","username",'phone'];
    }

    public function getGuardName(): string
    {
        return "customer";
    }

    //

    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
