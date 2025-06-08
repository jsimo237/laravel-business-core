<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;


use Kirago\BusinessCore\Modules\BaseModel;

class Advantage extends BaseModel {

    protected $table = "subscriptions_mgt__advantages";

    protected static function newFactory(){
        return AdvantageFactory::new();
    }
}
