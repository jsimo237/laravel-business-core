<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Contact;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new Contact)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->comment("Le nom de l'expéditeur");
            $table->string('email')->nullable()
                ->comment("l'email de l'expéditeur");
            $table->string('subject')->nullable()
                ->comment("L'object de la requete");
            $table->longText('message')->nullable()
                ->comment("Le contenu de la requête");
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
        Schema::dropIfExists((new Contact)->getTable());
    }
};
