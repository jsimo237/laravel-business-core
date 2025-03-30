<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcProduct;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;

return new class extends Migration {

    public function up(){

        $classes = [
            BcOrganization::class,BcUser::class, BcProduct::class,
            BcSetting::class
        ];

        $column = "is_active";
        foreach ($classes as $class) {
            $model = (new $class);

            if(Schema::hasTable($model->getTable())){
                Schema::whenTableDoesntHaveColumn($model->getTable(), $column,function (Blueprint $table) use ($column) {
                    $table->boolean($column)->default(true)
                        ->comment("Détermine si la ligne est active(visible par le front-ent)");
                });
            }


        }
    }

};
