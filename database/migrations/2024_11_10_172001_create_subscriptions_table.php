<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Constants\BcSubscriptionStatuses;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create((new BcSubscription)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string("reference",60)
                ->unique(uniqid("UQ_"))
                ->comment("La reference unique de la souscription");

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->decimal('amount',20,4)->default(0);

            $table->boolean('active')->default(true)
               // ->storedAs('start_at <= CURRENT_TIMESTAMP AND end_at >= CURRENT_TIMESTAMP')
            ;

            $table->foreignIdFor(BcPackage::class,"package_id")
                ->constrained((new BcPackage)->getTable(), (new BcPackage)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] le package");

            $table->string("status",50)->default(BcSubscriptionStatuses::INIATED->value)
                ->comment("Le statut");

            $table->timestamp('initiated_at')->nullable()
                ->comment("La date a la quelle ça été initée");

            $table->timestamp('completed_at')->nullable()
                ->comment("La date de confirmation");

            $table->nullableUlidMorphs('subscriber',uniqid("INDX_"));

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new BcSubscription)->getTable());
    }
};
