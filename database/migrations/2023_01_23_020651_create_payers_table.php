<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Models\PaymentManagement\Payer;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create((new Payer)->getTable(), function (Blueprint $table) {

            $table->id();
            $table->string('first_name',100)->nullable()
                ->comment("Le nom");
            $table->string('last_name',100)->nullable()
                ->comment("Le prénom");

            $table->string('email')->nullable()->unique(uniqid("UQ_"))
                ->comment("L'email");
            $table->string('phone')->nullable()->unique(uniqid("UQ_"))
                ->comment("le numéro de téléphone");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new Payer)->getTable());
    }
};
