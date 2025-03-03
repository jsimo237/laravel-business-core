<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model{
    use HasFactory,SoftDeletes;

    const TABLE_NAME = "polymorph_mgt__phones";
    const MORPH_ID_COLUMN = "phonable_id";
    const MORPH_TYPE_COLUMN = "phonable_type";
    const MORPH_FUNCTION_NAME = "phonable";

    protected $table = self::TABLE_NAME;
    protected $guarded = ['id',"created_at"];

    public function phonable(){
        return $this->morphTo(__FUNCTION__,
            self::MORPH_TYPE_COLUMN,self::MORPH_ID_COLUMN);
    }
}
