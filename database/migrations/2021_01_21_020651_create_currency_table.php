<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcCurrency;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::hasTable((new BcCurrency)->getTable())){
                Schema::create((new BcCurrency)->getTable(), function (Blueprint $table) {

                    $table->string("code",50)->primary();
                    $table->string('title',100)->comment("Le nom");

                    $table->char('symbol_left',2)->nullable();
                    $table->char('symbol_right',2)->nullable();
                    $table->bigInteger('decimal_place')->nullable();
                    $table->decimal('value',10,9)->nullable();
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
        Schema::dropIfExists((new BcCurrency)->getTable());
    }
};
