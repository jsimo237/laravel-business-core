<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model{
    use HasFactory;

    protected $table = "settings_mgt__langs";
    const FK_ID = "lang_id";
    protected $guarded = [];

}
