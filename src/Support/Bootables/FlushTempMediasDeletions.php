<?php

namespace Kirago\BusinessCore\Support\Bootables;

use Kirago\BusinessCore\Modules\MediaManagement\Repositories\MediaDeletionRepository;
use Illuminate\Database\Eloquent\Model;

trait FlushTempMediasDeletions
{


    public static function bootFlushTempMediasDeletions(){

        static::saved(function (Model $model){
            (new MediaDeletionRepository)->processToDeleteMedias($model);
        });
    }
}