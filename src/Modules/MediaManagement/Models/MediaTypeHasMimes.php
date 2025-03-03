<?php

namespace Kirago\BusinessCore\Modules\MediaManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;


class MediaTypeHasMimes extends BaseModel {


    protected string $table = "medias_mgt__mymes_has_types";

    public function getObjectName(): string
    {
        return $this->name;
    }
}
