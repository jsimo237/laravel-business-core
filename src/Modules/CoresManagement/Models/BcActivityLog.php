<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;
use \Spatie\Activitylog\Models\Activity as SpatieActivityLog;

/**
 * @property string code
 * @property string label
 * @property string description
 */
class BcActivityLog extends SpatieActivityLog {


    const TABLE_NAME = "cores_mgt__activity_logs";
    protected $table = self::TABLE_NAME;

    public function getObjectName(): string
    {
        return $this->label;
    }
}
