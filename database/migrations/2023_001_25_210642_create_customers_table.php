<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;

return new class extends Migration {

    public function up(){

        if(!Schema::hasTable((new BcCustomer)->getTable())){
            Schema::create((new BcCustomer)->getTable(), function (Blueprint $table) {
                $table->id();

                $table->string('firstname',100)
                    ->comment("Le nom");
                $table->string('lastname',100)->nullable()
                    ->comment("Le prénom");

                $table->string('fullname')->nullable()
                        ->storedAs("concat(firstname,' ',lastname)")
                        ->comment("Le nom complet");

                $table->string('phone',20)->nullable()
                    ->comment("Le numéro de téléphone");

                $table->string('initials',2)->nullable()
                    ->storedAs("concat(upper(left(firstname,1)), upper(left(lastname,1)))")
                    ->comment("Les initiales du prénom et du nom");

                $table->string('username',20)->nullable()
                    ->comment("Le nom d'utilisateur");

                $table->string('email')
                    ->comment("L'email");

            });
        }

    }


    public function down(){
        Schema::dropIfExists((new BcCustomer)->getTable());
    }
};
