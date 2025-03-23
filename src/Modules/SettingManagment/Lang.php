<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;

/**
 * @property string code
 * @property string label
 * @property string description
 */
class Lang extends BaseBcModel {

    use HasCustomPrimaryKey;

    protected $table = "settings_mgt__langs";

    public function getObjectName(): string
    {
        return $this->label;
    }
}
