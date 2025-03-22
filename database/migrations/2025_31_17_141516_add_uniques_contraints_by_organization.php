<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;

return new class extends Migration {

    public function up(){

        $classes = [
            Customer::class => [
                "columns" => ['email',"phone","username"]
            ],
            Staff::class => [
                "columns" => ['email',"phone","username"]
            ],

            Product::class => [
                "columns" => ['sku']
            ],

            Order::class => [
                "columns" => ['code']
            ],
            Invoice::class => [
                "columns" => ['code']
            ],

           Setting::class => [
                "columns" => ['key']
            ],
        ];

        foreach ($classes as $class => $options) {
            $model = (new $class);

            if ($columns = $options['columns'] ?? []){
                $columns[] = "organization_id";

//                Schema::whenTableDoesntHaveColumn($model->getTable(), "organization_id",function (Blueprint $table) use ($column) {
//
//                    $table->foreignIdFor(Organization::class,"organization_id")->nullable()
//                        ->constrained((new Organization)->getTable(), (new Organization)->getKeyName(), uniqid("FK_"))
//                        ->cascadeOnUpdate()->cascadeOnDelete()
//                        ->comment("[FK] l'organisation");
//                });

                Schema::table($model->getTable(),function (Blueprint $table) use ($columns) {
                    $table->unique($columns,uniqid("UQ_"));
                });
            }


        }
    }

};
