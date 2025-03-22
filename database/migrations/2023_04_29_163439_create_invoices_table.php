<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Enums\BillingInformations;
use Kirago\BusinessCore\Enums\InvoiceStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
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

        Schema::create((new Invoice)->getTable(), function (Blueprint $table) {
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


            $table->nullableUlidMorphs('recipient');

            $table->string("status",50)->default(InvoiceStatuses::CREATED->value)
                  ->comment("Le statut");

            $table->timestamp('expired_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->foreignIdFor(Order::class,'order_id')->nullable()
                ->constrained((new Order)->getTable(), (new Order)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la commande");

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
        Schema::dropIfExists((new Invoice)->getTable());
    }
};
