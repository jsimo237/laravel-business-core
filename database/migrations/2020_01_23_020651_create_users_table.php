<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if(!Schema::hasTable((new User)->getTable())){
                Schema::create((new User)->getTable(), function (Blueprint $table) {

                    $table->id();

                    $table->string('firstname',100)
                        ->comment("Le nom");

                    $table->string('lastname',100)->nullable()
                        ->comment("Le prénom");

                    $table->string('phone',20)->nullable()
                        ->comment("Le numéro de téléphone");

                    $table->string('fullname')
                        ->storedAs("concat(firstname,' ',lastname)")
                        ->comment("Le nom complet");

                    $table->string('initials',2)->nullable()
                        ->storedAs("concat(upper(left(firstname,1)), upper(left(lastname,1)))")
                        ->comment("Les initiales du prénom et du nom");

                    $table->string('username',20)->nullable()
                        ->comment("Le nom d'utilisateur");

                    $table->string('email')->nullable()
                        ->comment("L'email");

                    $table->string('password')->nullable()
                        ->comment("Le mot de passe crypté");

                    $table->timestamp('email_verified_at')->nullable()
                            ->comment("La date de vérification de l'email");

                    $table->timestamp('phone_verified_at')->nullable()
                            ->comment("La date de vérification de l'email");

                    $table->boolean("is_active")->default(true)
                        ->comment("Détermine l'user le proprietaire");

                    $table->boolean('is_2fa_enabled')->default(false);

                    $table->rememberToken()
                        ->comment("le dernier token de réinitialisation du mot de passe");

                    $table->nullableUlidMorphs('entity', uniqid("POLY_INDEX_"));

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
        Schema::dropIfExists((new User)->getTable());
    }
};
