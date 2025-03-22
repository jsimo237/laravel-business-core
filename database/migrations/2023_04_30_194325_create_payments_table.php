<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Enums\PaymentSource;
use Kirago\BusinessCore\Enums\PaymentStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Payment;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Payment)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code',50)->unique(uniqid("UQ_"));

            $table->string('source_code',100)->default(PaymentSource::UNKNOWN->value);
            $table->string('source_reference',100)->nullable();
            $table->json('source_response')->nullable();

            $table->decimal('amount',20,4)->default(0);

            $table->text('note')->nullable();

            $table->foreignIdFor(Invoice::class,'invoice_id')->nullable()
                ->constrained((new Invoice)->getTable(), (new Invoice)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] la facture");


            $table->string("status",50)->default(PaymentStatuses::DRAFT->value)
                ->comment("Le statut");

            $table->timestamp('paied_at')
                ->comment("La date auquel le paiement a été effectué");

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
        Schema::dropIfExists((new Payment)->getTable());
    }
};
