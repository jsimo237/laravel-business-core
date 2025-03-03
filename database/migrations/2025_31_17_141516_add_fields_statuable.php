<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Models\TransactionManagement\Transaction;
use Kirago\BusinessCore\Models\WalletManagement\WalletCollection;
use Kirago\BusinessCore\Modules\CoreManagement\Models\Status;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SettingManagment\StatusChange;

return new class extends Migration {

    public function up(){

        $classes = [
            Order::class,Invoice::class,
            StatusChange::class,
        ];

        $column = "status_code";
        foreach ($classes as $class) {
            $model = (new $class);

            Schema::whenTableDoesntHaveColumn($model->getTable(), $column,function (Blueprint $table) use ($column) {

                $table->foreignIdFor(Status::class,$column)->nullable()
                    ->constrained((new Status)->getTable(), (new Status)->getKeyName(), uniqid("FK_"))
                    ->cascadeOnUpdate()->cascadeOnDelete()
                    ->comment("[FK] le statut");

            });


        }
    }

};
