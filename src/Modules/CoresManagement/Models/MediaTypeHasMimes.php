<?php

namespace Kirago\BusinessCore\Modules\CoreManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;


class MediaTypeHasMimes extends BaseBcModel {


    protected $table = "cores_mgt__mymes_has_types";

    public function getObjectName(): string
    {
        return $this->name;
    }
}
