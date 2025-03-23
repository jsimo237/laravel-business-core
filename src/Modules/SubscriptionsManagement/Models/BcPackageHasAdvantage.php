<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseBcModel;

/**
 * @property string name
 */
class BcPackageHasAdvantage extends BaseBcModel {

    protected $table = "subscriptions_mgt__package_has_advantages";


    public function getObjectName(): string
    {
        return $this->name;
    }
}
