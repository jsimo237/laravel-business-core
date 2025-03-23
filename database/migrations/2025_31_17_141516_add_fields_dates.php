<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\CoreManagement\Models\BcMedia;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcAddress;
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
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $classes = [
            BcRole::class, BcPermission::class, BcUser::class, BcOrganization::class,
            BcOrder::class,BcInvoice::class, BcOrderItem::class, BcInvoiceItem::class,
            BcProduct::class, BcCustomer::class, BcStaff::class,
            BcCountry::class, BcState::class, BcCity::class, BcQuarter::class, BcAddress::class,
            BcMedia::class,
        ];

        foreach ($classes as $class) {
            $model = (new $class);
            $table_name = $model->getTable();

            Schema::whenTableDoesntHaveColumn($table_name, "created_at",function (Blueprint $table)  {
                $table->timestamp('created_at')->nullable();
            });
            Schema::whenTableDoesntHaveColumn($table_name, "updated_at",function (Blueprint $table)  {
                $table->timestamp('updated_at')->nullable();
            });

            Schema::whenTableDoesntHaveColumn($table_name, "deleted_at",function (Blueprint $table)  {
                $table->timestamp('deleted_at')->nullable();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        //
    }
};
