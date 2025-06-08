<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BillingInformations;

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

                $table->text('description')->nullable()
                    ->comment("La description");

                $table->string('slug')->unique(uniqid("UQ_"))
                    ->comment("Le slug unique");

                $table->string('email',100)->unique(uniqid("UQ_"))->nullable()
                    ->comment("L'email");
                $table->string('phone',60)->nullable()
                    ->comment("Le numéro de téléphone");

                // Billing infos
                $table->enum('billing_entity_type',BillingInformations::values())->default(BillingInformations::TYPE_COMPANY->value);
                $table->string('billing_company_name',60)->nullable();
                $table->string('billing_firstname',60)->nullable();
                $table->string('billing_lastname',60)->nullable();
                $table->string('billing_country',60)->nullable();
                $table->string('billing_state',60)->nullable();
                $table->string('billing_city',60)->nullable();
                $table->string('billing_zipcode',100)->nullable();
                $table->string('billing_address',100)->nullable();
                $table->string('billing_email',100)->nullable();

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
