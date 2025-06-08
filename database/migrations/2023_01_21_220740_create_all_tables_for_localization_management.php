<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Address;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Timezone;

return new class extends Migration {


    public function up()
    {

        $this->createCountryTable();
        $this->createStateTable();
        $this->createCityTable();
        $this->createQuarterTable();
        $this->createAddressTable();
        $this->createTimeZoneTable();
    }

    protected function createCountryTable()
    {
        if (!Schema::hasTable((new Country)->getTable())) {
            Schema::create((new Country)->getTable(), function (Blueprint $table) {
                $table->id();

                $table->string('code',10)->unique(uniqid("UQ_"))
                    ->comment("Le code unique");
                $table->json("data")->nullable()
                    ->comment("les infos récupéré via l'api (ex : '') ");

                $table->boolean('is_active')->default(true)
                    ->comment("Determine si c'est actif");
                $table->timestamps();
                $table->softDeletes();

            });
        }
    }

    protected function createStateTable()
    {
        if (!Schema::hasTable((new State)->getTable())) {
            Schema::create((new State)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Littoral')");
                $table->foreignIdFor(Country::class, "country_id")->nullable()
                    ->constrained((new Country)->getTable(), (new Country)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] le pays");

                $table->boolean('is_active')->default(true)
                    ->comment("Determine si c'est actif");
                $table->nullableTimestamps();
                $table->softDeletes();

            });
        }
    }

    protected function createCityTable()
    {
        if (!Schema::hasTable((new City)->getTable())) {
            Schema::create((new City)->getTable(), function (Blueprint $table) {

                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Douala')");
                $table->foreignIdFor(State::class, State::FK_ID)->nullable()
                    ->constrained((new State)->getTable(), (new State)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] l'état/région associé");
                $table->boolean('is_active')->default(true)
                    ->comment("Determine si c'est actif");
                $table->nullableTimestamps();
                $table->softDeletes();

            });
        }
    }

    protected function createQuarterTable()
    {
        if (!Schema::hasTable((new Quarter)->getTable())) {
            Schema::create((new Quarter)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Ndog-Passi 2')");
                $table->foreignIdFor(City::class, City::FK_ID)->nullable()
                    ->constrained((new City)->getTable(), (new City)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] la ville");

                $table->boolean('is_active')->default(true)
                    ->comment("Determine si c'est actif");
                $table->nullableTimestamps();
                $table->softDeletes();

            });
        }
    }

    protected function createAddressTable()
    {
        if (!Schema::hasTable((new Address)->getTable())) {

            Schema::create((new Address)->getTable(), function (Blueprint $table) {

                $table->id();

                $table->nullableUlidMorphs('addressable',uniqid("POLY_INDEX_"));

                $table->string('name')->comment("le nom de l'addresse");

                $table->string('title')->default('Main');

                $table->string('contact_full_name')->nullable()
                    ->comment("nom complet de la personne référence à cette addresse");

                $table->string('contact_email')->nullable()
                    ->comment("l'email de contact (ex : 'company@app.com')");
                $table->string('contact_phone')->nullable()
                    ->comment("le téléphone de contact (ex : '237 (683523318)')");
                $table->string('street')->nullable()
                    ->comment("la rue (ex : 'RES')");
                $table->string('address1')->nullable()
                    ->comment("address line 1");
                $table->string('address2')->nullable()
                    ->comment("address line 2");

                $table->boolean('is_default')
                    ->comment("Determine si c'est l'adresse par défaut")
                    ->default(false);

                $table->foreignIdFor(Country::class, Country::FK_ID)->nullable()
                    ->constrained((new Country)->getTable(), (new Country)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] le pays");

                $table->foreignIdFor(State::class, State::FK_ID)->nullable()
                    ->constrained((new State)->getTable(), (new State)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] l'état/région");

                $table->foreignIdFor(City::class, City::FK_ID)->nullable()
                    ->constrained((new City)->getTable(), (new City)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] la ville");

                $table->foreignIdFor(Quarter::class, Quarter::FK_ID)->nullable()
                    ->constrained((new Quarter)->getTable(), (new Quarter)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] le quartier");

                $table->string('zip_code', 10)->nullable()
                    ->comment("zip code");
                $table->string('po_box', 10)->nullable()
                    ->comment("code postal");
                $table->decimal('latitude', 10, 7)->nullable()
                    ->comment("latitude");
                $table->decimal('longitude', 10, 7)->nullable()
                    ->comment("longitude");
                $table->boolean('default')->default(false)
                    ->comment("determine si c'est l'addresse par défaut");


               // $table->nullableUlidMorphs('author', uniqid("POLY_INDEX_"));
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    protected function createTimeZoneTable()
    {
        if (!Schema::hasTable((new Timezone)->getTable())) {
            Schema::create((new Timezone)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('code',100)->unique(uniqid("UQ_"))
                    ->comment("[PK] le code");

                $table->text("description")->nullable()
                    ->comment("[FK] la ville");

                $table->timestamps();
                $table->softDeletes();

            });
        }
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists((new Country)->getTable());
        Schema::dropIfExists((new State)->getTable());
        Schema::dropIfExists((new City)->getTable());
        Schema::dropIfExists((new Address)->getTable());
        Schema::dropIfExists((new Timezone)->getTable());
    }
};
