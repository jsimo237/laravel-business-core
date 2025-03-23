<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcAddress;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCity;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCountry;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcQuarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcState;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcTimezone;

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
        if (!Schema::hasTable((new BcCountry)->getTable())) {
            Schema::create((new BcCountry)->getTable(), function (Blueprint $table) {
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
        if (!Schema::hasTable((new BcState)->getTable())) {
            Schema::create((new BcState)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Littoral')");
                $table->foreignIdFor(BcCountry::class, "country_id")->nullable()
                    ->constrained((new BcCountry)->getTable(), (new BcCountry)->getKeyName(), uniqid("FK_"))
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
        if (!Schema::hasTable((new BcCity)->getTable())) {
            Schema::create((new BcCity)->getTable(), function (Blueprint $table) {

                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Douala')");
                $table->foreignIdFor(BcState::class, BcState::FK_ID)->nullable()
                    ->constrained((new BcState)->getTable(), (new BcState)->getKeyName(), uniqid("FK_"))
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
        if (!Schema::hasTable((new BcQuarter)->getTable())) {
            Schema::create((new BcQuarter)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name')
                    ->comment("Le nom (ex : 'Ndog-Passi 2')");
                $table->foreignIdFor(BcCity::class, BcCity::FK_ID)->nullable()
                    ->constrained((new BcCity)->getTable(), (new BcCity)->getKeyName(), uniqid("FK_"))
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
        if (!Schema::hasTable((new BcAddress)->getTable())) {

            Schema::create((new BcAddress)->getTable(), function (Blueprint $table) {

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

                $table->foreignIdFor(BcCountry::class, BcCountry::FK_ID)->nullable()
                    ->constrained((new BcCountry)->getTable(), (new BcCountry)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] le pays");

                $table->foreignIdFor(BcState::class, BcState::FK_ID)->nullable()
                    ->constrained((new BcState)->getTable(), (new BcState)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] l'état/région");

                $table->foreignIdFor(BcCity::class, BcCity::FK_ID)->nullable()
                    ->constrained((new BcCity)->getTable(), (new BcCity)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] la ville");

                $table->foreignIdFor(BcQuarter::class, BcQuarter::FK_ID)->nullable()
                    ->constrained((new BcQuarter)->getTable(), (new BcQuarter)->getKeyName(), uniqid("FK_"))
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
        if (!Schema::hasTable((new BcTimezone)->getTable())) {
            Schema::create((new BcTimezone)->getTable(), function (Blueprint $table) {
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
        Schema::dropIfExists((new BcCountry)->getTable());
        Schema::dropIfExists((new BcState)->getTable());
        Schema::dropIfExists((new BcCity)->getTable());
        Schema::dropIfExists((new BcAddress)->getTable());
        Schema::dropIfExists((new BcTimezone)->getTable());
    }
};
