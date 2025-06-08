<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxHasGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new TaxHasGroup)->getTable(), function (Blueprint $table) {
            $table->id();


            $table->foreignIdFor(Tax::class,'tax_id')
                ->constrained((new Tax)->getTable(), (new Tax)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la taxe");

            $table->foreignIdFor(TaxGroup::class,'tax_group_id')
                ->constrained((new TaxGroup)->getTable(), (new TaxGroup)->getKeyName(), uniqid("FK_"))
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
        Schema::dropIfExists((new TaxHasGroup)->getTable());
    }
};
