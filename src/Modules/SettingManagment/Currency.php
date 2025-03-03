<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Support\Bootables\Paginable;

class Currency extends Model{
    use HasFactory,Paginable;

    protected $table = "settings_mgt__currencies";
    public $timestamps = false;
    protected $guarded = [];
}
