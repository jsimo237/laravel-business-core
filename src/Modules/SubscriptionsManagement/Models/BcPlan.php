<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;


use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories\PlanFactory;

/**
 * @property string title
 */
class BcPlan extends BaseBcModel {

    protected $table = "subscriptions_mgt__plans";


    protected static function newFactory(){
        return PlanFactory::new();
    }

    public function getObjectName(): string
    {
        return $this->title;
    }

    //RELATIONS
    public function packages(){
        return $this->hasMany(BcPackage::class,"plan_id");
    }
}
