<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Address;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Media;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $classes = [
            Role::class, Permission::class, User::class, Organization::class,
            Order::class,Invoice::class, OrderItem::class, InvoiceItem::class,
            Product::class, Customer::class, Staff::class,
            Country::class, State::class, City::class, Quarter::class, Address::class,
            Media::class,
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
