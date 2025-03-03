<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if (!Schema::hasTable((new City)->getTable())){
            Schema::create((new City)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignIdFor(State::class,'state_id')
                    ->constrained((new State)->getTable(), (new State)->getKeyName())
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK]");
                $table->boolean('active')->default(true);
                $table->nullableTimestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable((new Quarter())->getTable())){
            Schema::create((new Quarter)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Ndog-Passi 2')");
                $table->foreignIdFor(City::class,"city_id")->nullable()
                    ->constrained((new City)->getTable(), (new City)->getKeyName(),uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] la ville");

                $table->boolean('active')->default(true)
                    ->comment("Determine si c'est actif");
                $table->nullableTimestamps();
                $table->softDeletes();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('cities');
    }
};
