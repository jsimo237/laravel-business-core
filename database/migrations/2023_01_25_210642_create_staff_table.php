<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;

return new class extends Migration {

    public function up(){

        if(!Schema::hasTable((new Staff)->getTable())){
            Schema::create((new Staff)->getTable(), function (Blueprint $table) {
                $table->id();

                $table->string('firstname',100)
                    ->comment("Le nom");
                $table->string('lastname',100)->nullable()
                    ->comment("Le prénom");


//                $table->computed ('full_name',"concat(firstname,' ',lastname)")->nullable()
//                        ->comment("Le nom complet");

                $table->string('fullname')->nullable()
                        ->storedAs("concat(firstname,' ',lastname)")
                        ->comment("Le nom complet");

                $table->string('username',20)->nullable()->unique(uniqid('UQ_'))
                    ->comment("Le nom d'utilisateur");

                $table->string('email')->unique(uniqid('UQ_'))
                    ->comment("L'email");

                $table->timestamp('email_verified_at')->nullable()
                    ->comment("La date de vérification de l'email");

                $table->timestamp('phone_verified_at')->nullable()
                    ->comment("La date de vérification du numéro de téléphone");

                $table->rememberToken()
                    ->comment("le dernier token de réinitialisation du mot de passe");


            });
        }

    }


    public function down(){
        Schema::dropIfExists((new Staff)->getTable());
    }
};
