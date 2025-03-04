<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new InvoiceItem)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(false);

            $table->text('excerpt')->nullable();
            $table->float('unit_price')->default(0);
            $table->integer('quantity')->default(0);
            $table->float('discount')->default(0);
            $table->json('taxes')->nullable();

            $table->nullableUlidMorphs('invoiceable',uniqid("POLY_INDEX_"));

            $table->foreignIdFor(Invoice::class,'invoice_id')
                ->constrained((new Invoice)->getTable(), (new Invoice)->getKeyName(), uniqid("FK_"))
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
        Schema::dropIfExists((new InvoiceItem)->getTable());
    }
};
