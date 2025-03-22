<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;

/**
 * @property string code
 * @property string name
 * @property string description
 */
class Timezone extends BaseModel {

    use HasCustomPrimaryKey;

    protected $table = "localization_mgt__timezones";

    public function getRouteKeyName(){
        return "code";
    }

    public function getObjectName(): string
    {
        return $this->name;
    }
}
