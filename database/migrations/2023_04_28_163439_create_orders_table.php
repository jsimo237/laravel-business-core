<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BillingInformations;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\OrderStatuses;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable((new Order)->getTable())){
        Schema::create((new Order)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code',60)
                ->unique(uniqid("UQ_"));


            $table->json('discounts')->nullable();
            $table->text('note')->nullable();

            $table->enum('billing_entity_type',BillingInformations::values())->default(BillingInformations::TYPE_INDIVIDUAL->value);
            $table->string('billing_company_name',60)->nullable();
            $table->string('billing_firstname',60)->nullable();
            $table->string('billing_lastname',60)->nullable();
            $table->string('billing_country',60)->nullable();
            $table->string('billing_state',60)->nullable();
            $table->string('billing_city',60)->nullable();
            $table->string('billing_zipcode',100)->nullable();
            $table->string('billing_address',100)->nullable();
            $table->string('billing_email',100)->nullable();

            $table->string("status",50)->default(OrderStatuses::DRAFT->value)
                ->comment("Le statut");

            $table->timestamp('expired_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->nullableUlidMorphs('recipient');


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
    public function down()
    {
        Schema::dropIfExists((new Order)->getTable());
    }
};
