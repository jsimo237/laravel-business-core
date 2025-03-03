<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Address;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new Address)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->nullableUlidMorphs('addressable',uniqid("POLY_INDEX_"));

            $table->string('title')->default('Main');

            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('contact_full_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->boolean('default')
                ->comment("Determine si c'est l'adresse par défaut")
                ->default(false);

            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();

            $table->string('zip_code')->nullable();
            $table->string('po_box')->nullable();

            $table->foreignIdFor(Country::class,'country_id')->nullable()
                ->constrained((new Country)->getTable(), (new Country)->getKeyName())
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK]");

            $table->foreignIdFor(State::class,'state_id')->nullable()
                ->constrained((new State)->getTable(), (new State)->getKeyName())
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK]");

            $table->foreignIdFor(City::class,'city_id')->nullable()
                ->constrained((new City)->getTable(), (new City)->getKeyName())
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK]");

            $table->foreignIdFor(Quarter::class,"quarter_id")->nullable()
                ->constrained((new Quarter)->getTable(), (new Quarter)->getKeyName(),uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la ville");

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new Address)->getTable());
    }
};
