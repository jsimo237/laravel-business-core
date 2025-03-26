<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if(!Schema::hasTable('personal_access_tokens')){
                Schema::create('personal_access_tokens', function (Blueprint $table) {
                    $table->bigIncrements('id');
                   // $table->morphs('tokenable');


                    $table->string("tokenable_id")->nullable()
                        ->comment("[polymorph_id] l'id du model authentifié  (ex : '1')");
                    $table->string("tokenable_type", 100)->nullable()
                        ->comment("[polymorph_type] le type du model authentifié");

                    $table->string('name');
                    $table->string('token', 64)->unique();
                    $table->text('abilities')->nullable();
                    $table->timestamp('last_used_at')->nullable();
                    $table->timestamp('expires_at')->nullable();
                    $table->timestamps();
                });
         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('personal_access_tokens');
    }
};
