<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create((new BcUser)->getTable(), function (Blueprint $table) {

            $table->id();

            $table->string('password')->nullable()
                ->comment("Le mot de passe crypté");

            $table->timestamp('email_verified_at')->nullable()
                    ->comment("La date de vérification de l'email");

            $table->boolean("is_active")->default(true)
                ->comment("Détermine l'user le proprietaire");

            $table->rememberToken()
                ->comment("le dernier token de réinitialisation du mot de passe");

            $table->nullableUlidMorphs('userable', uniqid("POLY_INDEX_"));


            $table->boolean('is_2fa_enabled')->default(false);

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
        Schema::dropIfExists((new BcUser)->getTable());
    }
};
