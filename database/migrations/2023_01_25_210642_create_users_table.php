<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration {

    public function up(){

        if(!Schema::hasTable((new User)->getTable())){
            Schema::create((new User)->getTable(), function (Blueprint $table) {
                $table->id();

                $table->string('first_name',60)
                    ->comment("Le nom");
                $table->string('last_name',60)->nullable()
                    ->comment("Le prénom");


//                $table->computed ('full_name',"concat(first_name,' ',last_name)")->nullable()
//                        ->comment("Le nom complet");

                $table->string('full_name')->nullable()
                        ->storedAs("concat(first_name,' ',last_name)")
                        ->comment("Le nom complet");

                $table->string('username',20)->nullable()->unique(uniqid('UQ_'))
                    ->comment("Le nom d'utilisateur");
                $table->string('email')->unique(uniqid('UQ_'))
                    ->comment("L'email");
                $table->string('password')->nullable()
                    ->comment("Le mot de passe crypté");
                $table->timestamp('email_verified_at')->nullable()
                    ->comment("La date de vérification de l'email");

                $table->boolean("is_manager")->default(false)
                    ->comment("Détermine l'user le proprietaire");

                $table->rememberToken()
                    ->comment("le dernier token de réinitialisation du mot de passe");
            });
        }

    }


    public function down(){
        Schema::dropIfExists((new User)->getTable());
    }
};
