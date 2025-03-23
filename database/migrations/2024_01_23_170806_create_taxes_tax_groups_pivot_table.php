<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxHasGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new BcTaxHasGroup)->getTable(), function (Blueprint $table) {
            $table->id();


            $table->foreignIdFor(BcTax::class,'tax_id')
                ->constrained((new BcTax)->getTable(), (new BcTax)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la taxe");

            $table->foreignIdFor(BcTaxGroup::class,'tax_group_id')
                ->constrained((new BcTaxGroup)->getTable(), (new BcTaxGroup)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] le groupe taxe");


            $table->unsignedInteger('seq_number')->default(0);
            $table->timestamps();

            $table->unique(['tax_id', 'tax_group_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new BcTaxHasGroup)->getTable());
    }
};
