<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SettingManagment\Comment;

return new class extends Migration {

    public function up(){

        if(!Schema::hasTable((new Comment)->getTable())){
            Schema::create((new Comment)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->longText("body")->nullable()
                    ->comment("Le message du commentaire");

                $table->string(Comment::MORPH_ID_COLUMN, 60)->nullable()
                    ->comment("[polymorph_id] l'id du model qui est commenté  (ex : '1')");
                $table->string(Comment::MORPH_TYPE_COLUMN, 100)->nullable()
                    ->comment("[polymorph_type] le type du model commenté  nom de cette table utilisé par laravel)
                  pour faire la correspondance de l'enregistrement  (ex : 'ticket')");

                $table->string(Comment::MORPH_AUTHOR_ID_COLUMN, 60)->nullable()
                    ->comment("[polymorph_id] l'id du model auteur du commentaire  (ex : 'R0001')");
                $table->string(Comment::MORPH_AUTHOR_TYPE_COLUMN, 100)->nullable()
                    ->comment("[polymorph_type] le type du model auteur du commentaire nom de cette table utilisé par laravel)
                  pour faire la correspondance de l'enregistrement  (ex : 'user')");

                $table->unsignedBigInteger("parent_id")->nullable()
                    ->comment("[FK] Le Commentaire parent  (représente une reponse à un commentaire)");
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }


    public function down(){
        Schema::dropIfExists((new Comment)->getTable());
    }
};
