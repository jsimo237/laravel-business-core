<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new BcOtpCode)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->ulidMorphs('identifier');
            $table->timestamp('expired_at');

            $table->foreignIdFor(BcOrganization::class,"organization_id")
                ->constrained((new BcOrganization)->getTable(), (new BcOrganization)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] l'orgasation");


            $table->timestamps();
            $table->softDeletes();


            $table->unique(['code',"organization_id"],uniqid('UQ_'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new BcOtpCode)->getTable());
    }
};
