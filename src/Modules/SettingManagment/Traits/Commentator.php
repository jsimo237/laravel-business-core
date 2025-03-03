<?php


namespace Kirago\BusinessCore\Modules\SettingManagment\Traits;


use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\SettingManagment\Comment;

trait Commentator{

    /** les commentaires crées par le modem
     * @return mixed
     */
    public function comments(){
        return $this->morphMany(Comment::class, Comment::MORPH_AUTHOR_FUNCTION_NAME,
            Comment::MORPH_AUTHOR_TYPE_COLUMN,Comment::MORPH_AUTHOR_ID_COLUMN);
    }

    /**Ajoute un commentaire au sur un model
     * @param array $datas
     * @param Model $model
     * @return mixed
     */
    public function addComment(array $datas ,Model $model){

       // throw_if(blank($model),)
        $datas[Comment::MORPH_ID_COLUMN] = $model->getKey(); // la valeur de l'identifiant [1]
        $datas[Comment::MORPH_TYPE_COLUMN] = $model->getMorphClass(); // [ticket]
        return  $this->comments()->create($datas);
    }
}
