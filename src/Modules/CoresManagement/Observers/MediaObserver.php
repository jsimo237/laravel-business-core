<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Observers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Media;

class MediaObserver
{


    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    // public $afterCommit = true;

    /**
     * Handle the Media "created" event.
     *
     * @param Media  $media
     * @return void
     */
    public function created(Media $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "updated" event.
     *
     * @param  Media  $media
     * @return void
     */
    public function updated(Media $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "deleted" event.
     *
     * @param  Media  $media
     * @return void
     */
    public function deleted(Media $media){
        // $media->forceDelete();
        //  Artisan::call("storage:link");
        write_log("medias/deleted",$media->only(['id','name']));

        //   File::delete($media->getUrl());
    }

    /**
     * Handle the Media "restored" event.
     *
     * @param  Media  $media
     * @return void
     */
    public function restored(Media $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "force deleted" event.
     *
     * @param  Media  $media
     * @return void
     */
    public function forceDeleted(Media $media){
        Artisan::call("storage:link");
    }


}