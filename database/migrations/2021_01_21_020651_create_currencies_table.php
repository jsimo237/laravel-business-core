<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Currency;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::hasTable((new Currency)->getTable())){
                Schema::create((new Currency)->getTable(), function (Blueprint $table) {

                  //  $table->id();

                    $table->string("code",10)->primary(uniqid("PK_"));

                    $table->string('title',100)->comment("Le nom");

                    $table->char('symbol_left',10)->nullable();
                    $table->char('symbol_right',10)->nullable();
                    $table->bigInteger('decimal_place')->default(2);
                    $table->decimal('value',20,12)->nullable();
                    $table->char('decimal_point',2)->nullable();
                    $table->char('thousand_point',2)->nullable();

                    $table->timestamps();
                    $table->softDeletes();
                });
         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new Currency)->getTable());
    }
};
