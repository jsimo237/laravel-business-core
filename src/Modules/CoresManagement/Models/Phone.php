<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;


use Kirago\BusinessCore\Modules\BaseModel;

class Phone extends BaseModel {


    const MORPH_ID_COLUMN = "entity_id";
    const MORPH_TYPE_COLUMN = "entity_type";
    const MORPH_FUNCTION_NAME = "entity";

    protected $table = "cores_mgt__phones";
    protected $guarded = ['id',"created_at"];

    public function entity(){
        return $this->morphTo(__FUNCTION__,
            self::MORPH_TYPE_COLUMN,self::MORPH_ID_COLUMN);
    }

    public function getObjectName(): string
    {
        // TODO: Implement getObjectName() method.
    }
}
