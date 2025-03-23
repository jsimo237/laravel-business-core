<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;


use Kirago\BusinessCore\Modules\BaseBcModel;

class Advantage extends BaseBcModel {

    protected $table = "subscriptions_mgt__advantages";

    protected static function newFactory(){
        return AdvantageFactory::new();
    }
}
