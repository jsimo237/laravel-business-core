<?php

namespace Kirago\BusinessCore\Modules\SettingManagment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Traits\Mediable;
use Kirago\BusinessCore\Support\Bootables\HasDates;
use Kirago\BusinessCore\Support\Bootables\Paginable;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Comment extends Model implements SpatieHasMedia{
    use HasFactory,SoftDeletes,HasDates,Paginable,
        InteractsWithMedia,Mediable;

    protected $guarded = ['id','created_at'];
    protected $table = "polymorph_mgt__comments";
    const MORPH_ID_COLUMN = "commentable_id";
    const MORPH_TYPE_COLUMN = "commentable_type";
    const MORPH_FUNCTION_NAME = "commentable";

    const MORPH_AUTHOR_ID_COLUMN = "author_id";
    const MORPH_AUTHOR_TYPE_COLUMN = "author_type";
    const MORPH_AUTHOR_FUNCTION_NAME = "author";

    public function commentable(){
        return $this->morphTo(__FUNCTION__,
            self::MORPH_TYPE_COLUMN,self::MORPH_ID_COLUMN);
    }

    public function author(){
        return $this->morphTo(__FUNCTION__,
            self::MORPH_AUTHOR_TYPE_COLUMN,self::MORPH_AUTHOR_ID_COLUMN);
    }

    /**
     * @return HasMany
     */
    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function childrens(){
        return $this->morphMany(self::class, self::MORPH_FUNCTION_NAME,
            self::MORPH_TYPE_COLUMN,self::MORPH_ID_COLUMN);
    }

    /**
     * Determine if this comment is written by the specified user.
     *
     * @param  $user
     * @return boolean
     */
    public function isWrittenBy(Model $user){
        return $user->is($this->author);
    }


    //FUCNTIONS
    public function registerMediaCollections(): void{
        $this->addMediaCollection('comments')
             ->onlyKeepLatest(3) // limiter le nombre de fichier dans la collection pour un commentaire
            ;
        // ... more
    }


    /**
     * @param $datas
     * @return Model
     */
    public function addReply($datas){
        return $this->replies()->create($datas);
    }

    //
    public function getReplyAuthorAttribute(){
        $author = $this->author;
        return array_merge($author->only('id',"full_name","avatar"),['type' => $author->getMorphClass()]);
    }

}
