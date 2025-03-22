<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new OrderItem)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('code',60)
                ->unique(uniqid("UQ_"));

            $table->text('note')->nullable();
            $table->decimal('unit_price',20,4)->default(0);
            $table->float('quantity')->default(0);
            $table->decimal('discount',10,4)->nullable()->default(0);
            $table->json('taxes')->nullable();

            $table->nullableUlidMorphs('orderable',uniqid("POLY_INDEX_"));

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
        Schema::dropIfExists((new OrderItem)->getTable());
    }
};
