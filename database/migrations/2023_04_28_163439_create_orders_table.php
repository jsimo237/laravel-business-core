<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Enums\BillingInformations;
use Kirago\BusinessCore\Enums\OrderStatuses;
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
            $table->string('code',60)
                ->unique(uniqid("UQ_"));


            $table->json('discounts');
            $table->text('note')->nullable();

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

            $table->string("status",50)->default(OrderStatuses::DRAFT->value)
                ->comment("Le statut");

            $table->timestamp('expired_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->nullableUlidMorphs('recipient');


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
