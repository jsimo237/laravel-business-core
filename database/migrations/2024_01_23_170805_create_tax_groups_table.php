<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new TaxGroup)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(false);


            $table->text('description')->nullable();
            $table->string('country_code')->nullable(false);

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists((new TaxGroup)->getTable());
    }
};
