<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @property string code
 * @property string name
 * @property string description
 */
class BcTimezone extends BaseBcModel {

    use Sluggable;

    protected $table = "localization_mgt__timezones";

    public function sluggable():array {
        return [
            'slug' => [
                'source' => 'code'
            ]
        ];
    }

    public function getRouteKeyName(){
        return "code";
    }

    public function getObjectName(): string
    {
        return $this->name;
    }
}
