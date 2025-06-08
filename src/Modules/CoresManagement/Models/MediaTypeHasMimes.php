<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;


class MediaTypeHasMimes extends BaseModel {


    protected $table = "cores_mgt__mymes_has_types";

    public function getObjectName(): string
    {
        return $this->name;
    }
}
