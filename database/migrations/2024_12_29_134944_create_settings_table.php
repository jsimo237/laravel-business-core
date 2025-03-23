<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new BcSetting)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->longText('value')->nullable();

            $table->foreignIdFor(BcOrganization::class,"organization_id")->nullable()
                ->constrained((new BcOrganization)->getTable(), (new BcOrganization)->getKeyName(), uniqid("FK_"))
                ->cascadeOnUpdate()->cascadeOnDelete()
                ->comment("[FK] l'organisation");

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists((new BcSetting)->getTable());
    }
};
