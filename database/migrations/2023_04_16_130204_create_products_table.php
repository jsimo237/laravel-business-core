<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Product)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('sku',60)->nullable(false);
            $table->string('name');
            $table->longText('description')->nullable();
            $table->float('buying_price')->comment("le prix d'achat");
            $table->float('selling_price')->comment("le prix de vente");

            $table->json('buying_taxes')->nullable()
                ->comment("les taxes a l'achat");

            $table->json('selling_taxes')->nullable()
                ->comment("les taxes a la vente");

            $table->boolean('can_be_sold')->default(false);
            $table->boolean('can_be_purchased')->default(false);

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
        Schema::dropIfExists((new Product)->getTable());
    }
};
