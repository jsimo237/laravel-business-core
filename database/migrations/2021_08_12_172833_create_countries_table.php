<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new Country)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code',10)->unique(uniqid("UQ_"));

            $table->json("data")->nullable()
                ->comment("les infos récupéré via l'api ");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new Country)->getTable());
    }


};
