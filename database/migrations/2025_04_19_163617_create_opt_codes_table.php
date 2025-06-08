<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\OtpCode;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new OtpCode)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->ulidMorphs('identifier');
            $table->timestamp('expired_at');

            $table->foreignIdFor(Organization::class,"organization_id")->nullable()
                ->constrained((new Organization)->getTable(), (new Organization)->getKeyName(), uniqid("FK_"))
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
        Schema::dropIfExists((new OtpCode)->getTable());
    }
};
