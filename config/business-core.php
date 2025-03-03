<?php


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

return [

    /**
     * Les models qui ont la capacité de s'authentifier
     */
    "authenticables" => [
        'customer' => \Kirago\BusinessCore\Modules\SalesManagement\Models\Customer::class,
        'staff' => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff::class,
    ],


    "models-interact-with-organization" => [

        \Kirago\BusinessCore\Modules\SecurityManagement\Models\User::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization::class,
        ],

        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization::class,
        ],


        \Kirago\BusinessCore\Modules\SecurityManagement\Models\Role::class ,

        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Contact::class,

        \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting::class,
        \Kirago\BusinessCore\Modules\MediaManagement\Models\Media::class,

        \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\Tax::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup::class,
        \Kirago\BusinessCore\Modules\SalesManagement\Models\Customer::class,

    ],

    "morphs-map" => [

        "organization" => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization::class,
        "staff" => \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff::class,

        //
        "media" =>  \Kirago\BusinessCore\Modules\MediaManagement\Models\Media::class,
        "comment" => \Kirago\BusinessCore\Modules\SettingManagment\Comment::class,
        "notification" => \Kirago\BusinessCore\Modules\SettingManagment\Notification::class,
        "status" => \Kirago\BusinessCore\Modules\CoreManagement\Models\Status::class,

        //Security
        "role" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\Role::class,
        "permission" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission::class,
        "user" => \Kirago\BusinessCore\Modules\SecurityManagement\Models\User::class,

        //localization
        "country" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country::class,
        "state" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\State::class,
        "city" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\City::class,
        "quarter" => \Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter::class,

        //



        //SalesManagegement
        "order" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        "order-item" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        "invoice" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        "invoice-item" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Order::class,
        "tax" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Tax::class,
        "tax-group" => \Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup::class,
        "customer" => \Kirago\BusinessCore\Modules\SalesManagement\Models\Customer::class,

    ],
];