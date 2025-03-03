<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model{
    use HasFactory;

    protected $table = "notifications";
    protected $guarded = [];
}
