<?php


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

return [

    /**
     * Les models qui ont la capacité de s'authentifier
     */
    "authenticables" => [
        'customer' => \Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcCustomer::class,
        'staff' => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff::class,
    ],

    "migrations" => [
        'sub-path' => "business-core",
    ],


    "models-interact-with-organization" => [

        \Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization::class,
        ],

        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization::class,
        ],


        /**
         * Simple BelongsTo RelationShips
         */
        \Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole::class ,
        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Contact::class,
        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting::class,
        \Kirago\BusinessCore\Modules\CoreManagement\Models\BcMedia::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcCustomer::class,
        \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan::class,
        \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage::class,
        \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription::class,

    ],

    "morphs-map" => [

        "organization" => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization::class,
        "staff" => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff::class,

        //CoreManagement
        "media" =>  \Kirago\BusinessCore\Modules\CoreManagement\Models\BcMedia::class,
        "notification" => \Kirago\BusinessCore\Modules\SettingManagment\Notification::class,

        //SecurityManagement
        "role" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole::class,
        "permission" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission::class,
        "user" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser::class,

        //LocalizationManagement
        "country" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCountry::class,
        "state" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcState::class,
        "city" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCity::class,
        "quarter" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcQuarter::class,


        //SalesManagegement
        "order" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        "order-item" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        "invoice" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        "invoice-item" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder::class,
        "tax" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax::class,
        "tax-group" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup::class,
        "customer" => \Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcCustomer::class,


        //SubscriptionsManagement
        "subscription" =>  \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription::class,
        "plan" =>  \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan::class,
        "package" =>  \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage::class,
        //"advantage" =>  \Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcAdvantage::class,
    ],
];