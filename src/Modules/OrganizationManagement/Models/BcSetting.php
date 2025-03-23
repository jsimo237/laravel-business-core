<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\BaseBcModel;


/**
 * @property string|int id
 */
class BcSetting extends BaseBcModel {

    protected $table = "organization_mgt__settings";



    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace("_"," ",$this->key));
    }

    public function getObjectName(): string
    {
        return $this->key;
    }
}
