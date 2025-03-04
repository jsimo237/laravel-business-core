<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Models\TransactionManagement\Transaction;
use Kirago\BusinessCore\Models\WalletManagement\WalletCollection;
use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SettingManagment\StatusChange;

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
        ];

        foreach ($classes as $class => $options) {
            $model = (new $class);

            if ($columns = $options['columns'] ?? []){
                $columns[] = "organization_id";

                Schema::table($model->getTable(),function (Blueprint $table) use ($columns) {
                    $table->unique($columns,uniqid("UQ_"));
                });
            }


        }
    }

};
