<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Constants\SubscriptionStatuses;
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

            $table->string("reference",60)->nullable()->unique(uniqid("UQ_"));

            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->decimal('amount',20,4)->default(0);

            $table->boolean('active')
                ->storedAs('start_at <= CURRENT_TIMESTAMP AND end_at >= CURRENT_TIMESTAMP');

            $table->foreignIdFor(BcPackage::class,"package_id")
                ->constrained((new BcPackage)->getTable(), (new BcPackage)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] le package");

            $table->string("status",50)->default(SubscriptionStatuses::UNPROCESSED->value)
                ->comment("Le statut");

            $table->nullableUlidMorphs('subscriber');

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
