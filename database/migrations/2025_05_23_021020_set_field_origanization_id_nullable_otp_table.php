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
        if(Schema::hasTable((new OtpCode)->getTable())){
            Schema::whenTableHasColumn((new OtpCode)->getTable(),"organization_id",function (Blueprint $table){

                $table->dropForeign(['organization_id']);

                // On rend la colonne nullable
                $table->foreignId('organization_id')
                    ->nullable()
                    ->change();

                // On recrée la contrainte avec cascade
                $table->foreign('organization_id')
                    ->references('id')
                    ->on((new Organization)->getTable())
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable((new OtpCode)->getTable())) {
            Schema::table((new OtpCode)->getTable(), function (Blueprint $table) {
                $table->dropForeign([$table->getTable().'_organization_id_foreign']);

                $table->foreignId('organization_id')
                    ->nullable(false)
                    ->change();

                $table->foreign('organization_id')
                    ->references('id')
                    ->on((new Organization)->getTable())
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
        }
    }
};
