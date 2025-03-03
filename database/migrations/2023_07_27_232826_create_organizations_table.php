<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        if (!Schema::hasTable((new Organization)->getTable())){
            Schema::create((new Organization)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom");
                $table->string('description')->nullable()
                    ->comment("La description");
                $table->string('email')->unique(uniqid("UQ_"))->nullable()
                    ->comment("L'email");
                $table->string('phone',60)->nullable()
                    ->comment("Le numéro de téléphone");

                $table->foreignIdFor(User::class,'manager_id')->nullable()
                    ->constrained((new User)->getTable(), (new User)->getKeyName(),uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] Le manager la companie");
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new Organization)->getTable());
    }
};
