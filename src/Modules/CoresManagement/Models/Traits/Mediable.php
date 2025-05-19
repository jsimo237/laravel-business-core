<?php


namespace Kirago\BusinessCore\Modules\CoresManagement\Models\Traits;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

trait Mediable{

    use CanUploadFiles;
    use FlushTempMediasDeletions;

    public static function bootMediable(){

        static::deleted(function (self $model) {
            $model->getMedia()->each->delete();
        });

        static::forceDeleted(function (self $model) {
            $model->getMedia()->each->forceDelete();
        });

        static::restored(function (self $model) {
            $model->media()->withTrashed()->get()->each->restore();
        });
    }

//    public function images(){}
//    public function videos(){}
//    public function documents(){}
//    public function audios(){}


    /** Le nom de la collection de groupe de tous les fichiers rattaché au enregistrements de ce model
     * @return string
     */
    public function getMediaCollectionName(): string
    {
        return $this->getRegisteredMediaCollections()->first()->name ?? "default";
    }


    /** Un seul fichier rataché à l'enregistrement
     * @return Attribute
     */
    public function image(): Attribute
    {
        return Attribute::make(
                get: fn () => $this->getFirstMediaUrl($this->getMediaCollectionName()),
            );
    }

    /**
     * Tous les chemins de fichiers rattachés au model
     * @return Attribute
     */
    public function allFilesPaths(): Attribute
    {
        return Attribute::make(
                    get: fn () => $this->getMedia($this->getMediaCollectionName())->map->getUrl(),
                );

    }

}
