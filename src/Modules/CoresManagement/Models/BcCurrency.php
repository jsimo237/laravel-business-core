<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Support\Bootables\Paginable;

class BcCurrency extends Model{
    use HasFactory,Paginable;

    protected $table = "cores_mgt__currencies";
    public $timestamps = false;
    protected $guarded = [];
}
