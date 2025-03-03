<?php


namespace Kirago\BusinessCore\Modules\SettingManagment\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Kirago\BusinessCore\Modules\SettingManagment\Comment;

trait Commentable {

    /**les commentaires rattachés au model
     * @return MorphMany
     */
    public function comments(){
        return $this->morphMany(Comment::class, Comment::MORPH_FUNCTION_NAME,
            Comment::MORPH_TYPE_COLUMN,Comment::MORPH_ID_COLUMN);
    }

    /**
     * @param array $datas
     * @param Model|null $author
     * @param Comment|null $parent
     * @return Comment
     */
    public function comment(array $datas , $author = null , Comment $parent = null){
        //si l'auteur est défini
        if ($author){
            $datas[Comment::MORPH_AUTHOR_ID_COLUMN] = $author->getKey(); // la valeur de l'identifiant [1]
            $datas[Comment::MORPH_AUTHOR_TYPE_COLUMN] = $author->getMorphClass(); // [ticket]
        }
        //si le parent est défini (c'est une reponse)
        if ($parent){
            $datas["parent_id"] = $parent->getKey(); // le commentaire parent [1]
        }
        $comment =  $this->comments()->create($datas);  //crée le commentaire

        //si des fichiers existents
        if (isset($datas["files"])){
            $comment->uploadFiles($datas["files"]);   //télécharge les fichiers
        }
        return Comment::find($comment->id);
    }


}
