<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create((new Setting)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->longText('value')->nullable();
            $table->string('type',30)->nullable();

            $table->foreignIdFor(Organization::class,"organization_id")->nullable()
                ->constrained((new Organization)->getTable(), (new Organization)->getKeyName(), uniqid("FK_"))
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
        Schema::dropIfExists((new Setting)->getTable());
    }
};
