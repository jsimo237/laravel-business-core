<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new BcInvoiceItem)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('code',60)
                ->unique(uniqid("UQ_"));

            $table->text('note')->nullable();
            $table->decimal('unit_price',20,4)->default(0);
            $table->float('quantity')->default(0);
            $table->decimal('discount',10,4)->default(0);
            $table->json('taxes')->nullable();

            $table->nullableUlidMorphs('invoiceable',uniqid("POLY_INDEX_"));

            $table->foreignIdFor(BcInvoice::class,'invoice_id')
                ->constrained((new BcInvoice)->getTable(), (new BcInvoice)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la facture");

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
        Schema::dropIfExists((new BcInvoiceItem)->getTable());
    }
};
