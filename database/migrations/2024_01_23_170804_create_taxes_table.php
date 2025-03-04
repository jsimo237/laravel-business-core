<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Tax)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('label')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('tax_type');
            $table->string('calculation_type');
            $table->string('calculation_base');
            $table->float('value');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('applied_in_taxable_amount')->default(false);
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
        Schema::dropIfExists((new Tax)->getTable());
    }
};
