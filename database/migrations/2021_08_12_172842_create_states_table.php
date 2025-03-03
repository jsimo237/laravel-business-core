<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new State)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignIdFor(Country::class,'country_id')
                ->constrained((new Country)->getTable(), (new Country)->getKeyName())
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK]");

            $table->boolean('active')->default(true);
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new State)->getTable());
    }
};
