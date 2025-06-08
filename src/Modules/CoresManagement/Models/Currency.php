<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;


/**
 * @property string code
 * @property string symbol_left
 * @property string symbol_right
 * @property string decimal_place
 * @property float value
 * @property string decimal_point
 * @property string thousand_point
 */
class Currency extends Model{

    use HasFactory,SoftDeletes,HasCustomPrimaryKey;

    protected $table = "cores_mgt__currencies";

    protected $guarded = [];
}
