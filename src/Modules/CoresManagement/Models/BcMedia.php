<?php

namespace Kirago\BusinessCore\Modules\CoreManagement\Models;

use Axn\EloquentAuthorable\AuthorableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\CoresManagement\Observers\MediaObserver;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Traits\HasOrganization;
use Kirago\BusinessCore\Support\Bootables\Auditable;
use Kirago\BusinessCore\Support\Bootables\InteractWithCommonsScopeFilter;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMediaModel;


/**
 * @property string|int id
 * @property string name
 * @property string uuid
 * @property string collection
 * @property string mime_type
 */
class BcMedia extends SpatieMediaModel{

    use HasFactory,SoftDeletes,
        AuthorableTrait,
        Auditable,
        HasOrganization,
        InteractWithCommonsScopeFilter;

    protected $guarded = ['id','created_at'];
    protected $table= "cores_mgt__medias";

    const MORPH_ID_COLUMN = "mediable_id";
    const MORPH_TYPE_COLUMN = "mediable_type";
    const MORPH_FUNCTION_NAME = "mediable";


    protected static function booted(){
        //static::addGlobalScope(new UserGlobalScope);

        self::observe([MediaObserver::class]);
    }


    //Relations

    /**
     * @return MorphTo
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo(
                    __FUNCTION__,
                    self::MORPH_TYPE_COLUMN,
                    self::MORPH_ID_COLUMN
                );
    }

    /**
     * @return MorphTo
     */
    public function model(): MorphTo{
        return $this->morphTo(
                    __FUNCTION__,
                    self::MORPH_TYPE_COLUMN,
                    self::MORPH_ID_COLUMN
                );
    }
    //public function mediaType(){
       // return $this->belongsTo(MediaType::class,'media_type_id');
    //}

    /**
     * @return BelongsTo
     */
    public function mime(): BelongsTo
    {
        return $this->belongsTo(MimeType::class,'mime_id');
    }

    //Getters

    /**
     * @return string
     */
    public function getMediaTypeAttribute(): string
    {
        if ($this->isAudio()){
            $type = "audio";
        }elseif ($this->isImage()){
            $type = "image";
        }elseif ($this->isVideo()){
            $type = "video";
        }elseif ($this->isDocument()){
            $type = "document";
        }else{
            $type = "unknow";
        }
        return $type;
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
          return $this->getPath();
    }


    //Functions

    /**
     * @return bool
     */
    public function isAudio(): bool
    {
        return in_array($this->mime_type , MimeType::audios());
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return in_array($this->mime_type , MimeType::videos());
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        return in_array($this->mime_type , MimeType::images());
    }

    public function isDocument(): bool
    {
        return in_array($this->mime_type , MimeType::documents());
    }
}
