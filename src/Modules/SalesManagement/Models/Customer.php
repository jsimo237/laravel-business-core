<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Kirago\BusinessCore\Modules\MediableModel;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Traits\HasUser;
use Kirago\BusinessCore\Support\Bootables\Personnable;

class Customer extends MediableModel implements AuthenticatableModelContract {

    use HasUser,Personnable;

    protected string $table = "sales_mgt__customers";


    //RELATIONS
    protected static function newFactory(){
      //  return CompanyFactory::new();
    }

    //FUNCTIONS
    public function getAuthIdentifiersFields(): array
    {
        return ["email","username",'phone'];
    }

    public function getGuardName(): string
    {
        return "customer";
    }

    //

}
