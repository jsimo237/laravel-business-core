<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Enums\BillingInformations;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Order)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(false);

            $table->dateTime('expiration_time')->nullable(false);
            $table->json('discounts')->nullable(false);
            $table->text('excerpt')->nullable(true);

            $table->enum('billing_entity_type',BillingInformations::values())->default(BillingInformations::TYPE_INDIVIDUAL->value);
            $table->string('billing_company_name')->nullable();
            $table->string('billing_firstname')->nullable();
            $table->string('billing_lastname')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_zipcode')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_email')->nullable();


            $table->nullableMorphs('recipient');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new Order)->getTable());
    }
};
