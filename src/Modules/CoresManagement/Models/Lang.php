<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;

/**
 * @property string code
 * @property string label
 * @property string description
 */
class Lang extends BaseModel {

    use HasCustomPrimaryKey;

    protected $table = "cores_mgt__langs";

    public function getObjectName(): string
    {
        return $this->label;
    }
}
