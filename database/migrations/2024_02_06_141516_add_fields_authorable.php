<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        //class pour slug-column
        $classes = [
            Role::class, User::class,
            Staff::class,
            Country::class, State::class,
            Organization::class,
            Order::class, Invoice::class, OrderItem::class, InvoiceItem::class,
            Customer::class, Product::class,
            Tax::class, TaxGroup::class,
            City::class,
            Quarter::class,
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

                    $table->foreignIdFor(User::class,$createdByColumnName)->nullable()
                        ->constrained((new User)->getTable(), (new User)->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'auteur de l'enrengistrement");
                });
            }
            if ($setUpdatedByColumnName){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $updatedByColumnName,function (Blueprint $table) use ($updatedByColumnName) {
//                    $table->unsignedBigInteger($updatedByColumnName)->nullable()
//                        ->comment("[FK] l'auteur de la dernière modification");

                    $table->foreignIdFor(User::class,$updatedByColumnName)->nullable()
                        ->constrained((new User)->getTable(), (new User)->getKeyName(), uniqid("FK_"))
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
