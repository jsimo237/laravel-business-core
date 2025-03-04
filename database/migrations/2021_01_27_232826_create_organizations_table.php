<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Enums\BillingInformations;
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

                // Billing infos
                $table->enum('billing_entity_type',BillingInformations::values())->default(BillingInformations::TYPE_COMPANY->value);
                $table->string('billing_company_name')->nullable();
                $table->string('billing_firstname')->nullable();
                $table->string('billing_lastname')->nullable();
                $table->string('billing_country')->nullable();
                $table->string('billing_state')->nullable();
                $table->string('billing_city')->nullable();
                $table->string('billing_zipcode')->nullable();
                $table->string('billing_address')->nullable();
                $table->string('billing_email')->nullable();


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
