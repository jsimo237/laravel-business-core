<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Support\Bootables\Paginable;

class DateTimeFormat extends Model{
    use HasFactory,SoftDeletes,
        Paginable;

    protected string $table = "localize_datetime_formats";
    public bool $timestamps = false;
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return "id";
    }
}
