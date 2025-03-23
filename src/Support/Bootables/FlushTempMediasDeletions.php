<?php

namespace Kirago\BusinessCore\Support\Bootables;

use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\CoresManagement\Repositories\MediaDeletionRepository;

trait FlushTempMediasDeletions
{


    public static function bootFlushTempMediasDeletions(){

        static::saved(function (Model $model){
            (new MediaDeletionRepository)->processToDeleteMedias($model);
        });
    }
}