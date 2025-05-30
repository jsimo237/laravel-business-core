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
        if(Schema::hasTable((new BcOtpCode)->getTable())){
            Schema::whenTableHasColumn((new BcOtpCode)->getTable(),"organization_id",function (Blueprint $table){

                $table->dropForeign(['organization_id']);

                // On rend la colonne nullable
                $table->foreignId('organization_id')
                    ->nullable()
                    ->change();

                // On recrée la contrainte avec cascade
                $table->foreign('organization_id')
                    ->references('id')
                    ->on((new BcOrganization)->getTable())
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
        if (Schema::hasTable((new BcOtpCode)->getTable())) {
            Schema::table((new BcOtpCode)->getTable(), function (Blueprint $table) {
                $table->dropForeign([$table->getTable().'_organization_id_foreign']);

                $table->foreignId('organization_id')
                    ->nullable(false)
                    ->change();

                $table->foreign('organization_id')
                    ->references('id')
                    ->on((new BcOrganization)->getTable())
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
        }
    }
};
