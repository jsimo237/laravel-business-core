<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Constants\BillingInformations;
use Kirago\BusinessCore\Constants\InvoiceStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create((new BcInvoice)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('code',60)
                ->unique(uniqid("UQ_"));
            
            $table->json('discounts');

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

            $table->nullableUlidMorphs('recipient');

            $table->string("status",50)->default(InvoiceStatuses::CREATED->value)
                  ->comment("Le statut");

            $table->timestamp('expired_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->foreignIdFor(BcOrder::class,'order_id')->nullable()
                ->constrained((new BcOrder)->getTable(), (new BcOrder)->getKeyName(), uniqid("FK_"))
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
        Schema::dropIfExists((new BcInvoice)->getTable());
    }
};
