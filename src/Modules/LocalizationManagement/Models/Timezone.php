<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Kirago\BusinessCore\Support\Bootables\Paginable;

class Timezone extends Model{
    use HasFactory,SoftDeletes,
        HasDates,Paginable;

    protected string $table = "localization_mgt__timezones";
    public bool $timestamps = false;
    protected $guarded = [];

    public function getRouteKeyName(){
        return "id";
    }

}
