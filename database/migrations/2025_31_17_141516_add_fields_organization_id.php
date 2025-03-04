<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\MediaManagement\Models\Media;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Contact;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration {

    public function up(){

        $classes = [
            User::class, Role::class,
            Order::class,Invoice::class, Setting::class,Contact::class, Staff::class,
            Tax::class, TaxGroup::class, Product::class,
            Customer::class,
            Media::class,
        ];

        $column = "organization_id";
        foreach ($classes as $class) {
            $model = (new $class);

            Schema::whenTableDoesntHaveColumn($model->getTable(), $column,function (Blueprint $table) use ($column) {

                $table->foreignIdFor(Organization::class,$column)->nullable()
                    ->constrained((new Organization)->getTable(), (new Organization)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] l'organisation");

            });


        }
    }

};
