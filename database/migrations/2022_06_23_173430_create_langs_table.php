<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Lang;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if(!Schema::hasTable((new Lang)->getTable())){
            Schema::create((new Lang)->getTable(), function (Blueprint $table) {
                $table->string('label')->nullable()
                      ->comment("le nom");

                $table->string('code',10)->primary()
                      ->comment("[PK] le code");

                $table->text('decription')->nullable()
                    ->comment("[PK] le code");

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
        Schema::dropIfExists((new Lang)->getTable());
    }
};
