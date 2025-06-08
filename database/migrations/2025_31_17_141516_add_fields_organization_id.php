<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Media;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\ContactForm;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Payment;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Package;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Plan;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Subscription;

return new class extends Migration {

    public function up(){

        $classes = [
            User::class, Role::class,
            Order::class,Invoice::class, Customer::class, Payment::class,Product::class,
            Setting::class, ContactForm::class, Staff::class,
            Tax::class, TaxGroup::class, Product::class,

            Media::class,ContactForm::class,
            Plan::class, Package::class, Subscription::class,
            config('activitylog.activity_model') ?? null,
        ];

        $column = "organization_id";

        foreach ($classes as $class) {

            if($class){

                $model = (new $class);

                if(Schema::hasTable($model->getTable())){
                    Schema::whenTableDoesntHaveColumn($model->getTable(), $column,function (Blueprint $table) use ($column) {

                        $table->foreignIdFor(Organization::class,$column)->nullable()
                            ->constrained((new Organization)->getTable(), (new Organization)->getKeyName(), uniqid("FK_"))
                            ->cascadeOnUpdate()->cascadeOnDelete()
                            ->comment("[FK] l'organisation");

                    });
                }
            }
        }
    }

};
