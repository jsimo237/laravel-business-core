<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Plan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create((new Plan)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->string("title",100);
            $table->text("description")->nullable();

//            $table->foreignIdFor(Module::class,"module_code")
//                ->constrained((new Module)->getTable(), (new Module)->getKeyName(), uniqid("FK_"))
//                ->cascadeOnUpdate()->cascadeOnDelete()
//                ->comment("[FK] le module");


           // $table->unique(["package_id","module_code"],uniqid("UQ_"));

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists((new Plan)->getTable());
    }
};
