<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        Schema::create((new PackageHasAdvantage)->getTable(), function (Blueprint $table) {
//
//            $table->foreignIdFor(Package::class,"package_id")
//                ->constrained((new Package)->getTable(), (new Package)->getKeyName(), uniqid("FK_"))
//                ->cascadeOnUpdate()->cascadeOnDelete()
//                ->comment("[FK] le package");
//
//            $table->foreignIdFor(Advantage::class,"advantage_code")
//                ->constrained((new Advantage)->getTable(), (new Advantage)->getKeyName(), uniqid("FK_"))
//                ->cascadeOnUpdate()->cascadeOnDelete()
//                ->comment("[FK] l'avantage");
//
//            $table->tinyText("value");
//
//            $table->unique(["package_id","advantage_code"],uniqid("UQ_"));
//        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new PackageHasAdvantage)->getTable());
    }
};
