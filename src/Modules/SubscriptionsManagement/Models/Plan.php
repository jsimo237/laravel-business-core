<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;


use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories\PlanFactory;

/**
 * @property string title
 */
class Plan extends BaseModel {

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
        return $this->hasMany(Package::class,"plan_id");
    }
}
