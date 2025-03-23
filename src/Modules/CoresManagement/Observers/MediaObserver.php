<?php

namespace Kirago\BusinessCore\Modules\CoresManagement\Observers;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Kirago\BusinessCore\Modules\CoreManagement\Models\BcMedia;

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
     * @param BcMedia  $media
     * @return void
     */
    public function created(BcMedia $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "updated" event.
     *
     * @param  BcMedia  $media
     * @return void
     */
    public function updated(BcMedia $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "deleted" event.
     *
     * @param  BcMedia  $media
     * @return void
     */
    public function deleted(BcMedia $media){
        // $media->forceDelete();
        //  Artisan::call("storage:link");
        write_log("medias/deleted",$media->only(['id','name']));

        //   File::delete($media->getUrl());
    }

    /**
     * Handle the Media "restored" event.
     *
     * @param  BcMedia  $media
     * @return void
     */
    public function restored(BcMedia $media){
        Artisan::call("storage:link");
    }

    /**
     * Handle the Media "force deleted" event.
     *
     * @param  BcMedia  $media
     * @return void
     */
    public function forceDeleted(BcMedia $media){
        Artisan::call("storage:link");
    }


}