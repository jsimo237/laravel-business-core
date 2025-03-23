<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCity;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCountry;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcQuarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcState;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcProduct;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        //class pour slug-column
        $classes = [
            BcRole::class, BcUser::class,
            BcStaff::class,
            BcCountry::class, BcState::class,
            BcOrganization::class,
            BcOrder::class, BcInvoice::class, BcOrderItem::class, BcInvoiceItem::class,
            BcCustomer::class, BcProduct::class,
            BcTax::class, BcTaxGroup::class,
            BcCity::class,
            BcQuarter::class,
        ];

        $authorableOptions = config("eloquent-authorable");
        $createdByColumnName = $authorableOptions['created_by_column_name'] ?? "created_by";
        $updatedByColumnName = $authorableOptions['updated_by_column_name'] ?? "updated_by";

        foreach ($classes as $class) {
            $model = (new $class);
            $authorable = $model->authorable;
            //$createdByColumnName = $authorable['created_by_column_name'] ?? $createdByColumnName;
            $setUpdatedByColumnName = $authorable['created_by_column_name'] ?? true;
            $setCreatedByColumn = $authorable['updated_by_column_name'] ?? true;

            if ($setCreatedByColumn){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $createdByColumnName,function (Blueprint $table) use ($createdByColumnName) {
//                $table->addAuthorableColumns(true, User::class)
//                    $table->unsignedBigInteger($createdByColumnName)->nullable()
//                        ->comment("[FK] l'auteur de l'enrengistrement");

                    $table->foreignIdFor(BcUser::class,$createdByColumnName)->nullable()
                        ->constrained((new BcUser)->getTable(), (new BcUser)->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'auteur de l'enrengistrement");
                });
            }
            if ($setUpdatedByColumnName){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $updatedByColumnName,function (Blueprint $table) use ($updatedByColumnName) {
//                    $table->unsignedBigInteger($updatedByColumnName)->nullable()
//                        ->comment("[FK] l'auteur de la dernière modification");

                    $table->foreignIdFor(BcUser::class,$updatedByColumnName)->nullable()
                        ->constrained((new BcUser)->getTable(), (new BcUser)->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'auteur de la dernière modification");
                });
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
