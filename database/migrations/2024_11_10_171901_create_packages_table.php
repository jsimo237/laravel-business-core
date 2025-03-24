<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new BcPackage)->getTable(), function (Blueprint $table) {

            $table->id();

            $table->string("name")->comment("Le nom");
            $table->bigInteger("count_days")->comment("Le nombre de jours");
           // $table->bigInteger("maximum_persons")->comment("Le nombre max de personnes");

            $table->decimal("price",14,4)->comment("Le prix");

            $table->text("description")->nullable();

            $table->string("type",100)->nullable()
                 ->comment("Le type package");

           // $table->string("frequency",50)->nullable()->comment("La fréquence");

            $table->foreignIdFor(BcPlan::class,"plan_id")->nullable()
                ->constrained((new BcPlan)->getTable(), (new BcPlan)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] le module");

            $table->unique(["type","plan_id"],uniqid("UQ_"));

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new BcPackage)->getTable());
    }
};
