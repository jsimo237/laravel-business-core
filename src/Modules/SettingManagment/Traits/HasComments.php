<?php


namespace Kirago\BusinessCore\Modules\SettingManagment\Traits;

use Kirago\BusinessCore\Modules\SettingManagment\Comment;

trait HasComments{

    public function comments(){
        return $this->morphMany(Comment::class, Comment::MORPH_FUNCTION_NAME,
            Comment::MORPH_TYPE_COLUMN,Comment::MORPH_ID_COLUMN);
    }

}
