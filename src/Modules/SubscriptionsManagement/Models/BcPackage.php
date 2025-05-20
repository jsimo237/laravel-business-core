<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;


use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories\PackageFactory;

/**
 * @property string name
 * @property float price
 * @property int count_days
 * @property string description
 * @property string frequency
 * @property string maximum_persons
 * @property string type
 * @property BcAdvantage[] advantages
 */
class BcPackage extends BaseBcModel {

    protected $table = "subscriptions_mgt__packages";

    protected static function newFactory(){
        return PackageFactory::new();
    }

    public function getObjectName(): string
    {
        return $this->name;
    }

    // RELATIONS

    public function plan(){
        return $this->belongsTo(BcPlan::class,"plan_id");
    }

    public function advantages(){
        return $this->belongsToMany(
            BcAdvantage::class,
            (new BcPackageHasAdvantage)->getTable(),
            "package_id",
            "advantage_code",

        )
        ->as('subscription')
        ->withPivot('value as count_value');
    }

    //
    public function advantagesList(){
        return $this->advantages
                    ->map(fn(BcAdvantage $advantage) => match ($advantage->count_value){
                      null => "(Illimité) ".$advantage->title,
                      default => "(x{$advantage->count_value}) ".$advantage->title,
                    })
                    ->toArray();
    }
}
