<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcProduct;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration {

    public function up(){

        $classes = [
           BcCustomer::class => [
                "columns" => ['email',"phone","username"]
            ],
            BcStaff::class => [
                "columns" => ['email',"phone","username"]
            ],

            BcProduct::class => [
                "columns" => ['sku']
            ],

            BcOrder::class => [
                "columns" => ['code']
            ],
            BcInvoice::class => [
                "columns" => ['code']
            ],

           BcSetting::class => [
                "columns" => ['key']
            ],

            BcUser::class => [
                "columns" => ['email',"phone","username"]
            ],
        ];

        foreach ($classes as $class => $options) {
            $model = (new $class);

            if ($columns = $options['columns'] ?? []){
                $columns[] = "organization_id";

                if(Schema::hasTable($model->getTable())){
                    Schema::table($model->getTable(),function (Blueprint $table) use ($columns) {
                        $table->unique($columns,uniqid("UQ_"));
                    });
                }
            }
        }
    }

};
