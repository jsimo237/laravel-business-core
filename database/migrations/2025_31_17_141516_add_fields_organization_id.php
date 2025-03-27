<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcMedia;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcContactForm;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcPayment;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcProduct;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;

return new class extends Migration {

    public function up(){

        $classes = [
            BcUser::class, BcRole::class,
            BcOrder::class,BcInvoice::class, BcCustomer::class, BcPayment::class,BcProduct::class,
            BcSetting::class, BcContactForm::class, BcStaff::class,
            BcTax::class, BcTaxGroup::class, BcProduct::class,

            BcMedia::class,BcContactForm::class,
            BcPlan::class, BcPackage::class, BcSubscription::class
        ];

        $column = "organization_id";

        foreach ($classes as $class) {
            $model = (new $class);

            Schema::whenTableDoesntHaveColumn($model->getTable(), $column,function (Blueprint $table) use ($column) {

                $table->foreignIdFor(BcOrganization::class,$column)->nullable()
                        ->constrained((new BcOrganization)->getTable(), (new BcOrganization)->getKeyName(), uniqid("FK_"))
                        ->cascadeOnUpdate()->cascadeOnDelete()
                        ->comment("[FK] l'organisation");

            });
        }
    }

};
