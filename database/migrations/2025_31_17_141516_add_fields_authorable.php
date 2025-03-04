<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        //class pour slug-column
        $classes = [
            Role::class, Organization::class,
            Setting::class, Product::class, Customer::class,
            Order::class, Invoice::class,
            OrderItem::class, InvoiceItem::class,
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

            if ($setCreatedByColumn and Schema::hasTable($model->getTable()) ){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $createdByColumnName,function (Blueprint $table) use ($createdByColumnName,$authorableOptions) {
//                $table->addAuthorableColumns(true, User::class)

                    $table->foreignIdFor($authorableOptions['users_model'],$createdByColumnName)->nullable()
                        ->constrained((new $authorableOptions['users_model'])->getTable(), (new $authorableOptions['users_model'])->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'auteur de l'enregistrement");
                });
            }
            if ($setUpdatedByColumnName and Schema::hasTable($model->getTable())){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $updatedByColumnName,function (Blueprint $table) use ($updatedByColumnName,$authorableOptions) {

                    $table->foreignIdFor($authorableOptions['users_model'],$updatedByColumnName)->nullable()
                        ->constrained((new $authorableOptions['users_model'])->getTable(), (new $authorableOptions['users_model'])->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'auteur de la dernière modification");

                });
            }

            Schema::whenTableDoesntHaveColumn((new StatusChange)->getTable(), "message",function (Blueprint $table) {
                $table->longText('message')->nullable()->comment("un message rattaché à ce change de statut");
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
