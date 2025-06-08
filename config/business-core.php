<?php

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Media;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Notification;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Address;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\City;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Country;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\Quarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\State;
use Kirago\BusinessCore\Modules\OrganizationManagement\Commands\CreateStaffCommand;
use Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares\EnsureRequestHasOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\ContactForm;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Setting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Staff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BaseCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Payment;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Product;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Tax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\TaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Middlewares\EnsureAuthGuardHeaderIsPresent;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\OtpCode;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Permission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\Role;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Advantage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Package;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Plan;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Subscription;

return [

    // 🔧 Active ou non la personnalisation des fichiers du package
    'customization' => false,

    'middlewares' => [
        'has-auth-guard-header' => EnsureAuthGuardHeaderIsPresent::class,
        'has-organization' => EnsureRequestHasOrganization::class
    ],

    // 🧑‍💼 Définition des classes utilisables pour l'authentification selon le rôle
    "authenticables" => [
        'customer' => Customer::class,
        'staff' => Staff::class,
    ],

    // 📁 Sous-dossier dans le dossier de migrations où seront placées celles du package
    "migrations_subpath" => "business-core",

    // 🔄 Mapping morphologique pour les relations morphTo dans les modèles
    "morphs_map" => [
        // OrganizationManagement
        "organization" => Organization::class,
        "staff" => Staff::class,

        // CoreManagement
        "media" =>  Media::class,
        "notification" => Notification::class,

        // SecurityManagement
        "role" => Role::class,
        "permission" => Permission::class,
        "user" => User::class,
        "otp-code" =>  OtpCode::class,

        // LocalizationManagement
        "country" => Country::class,
        "state" => State::class,
        "city" => City::class,
        "quarter" => Quarter::class,

        // SalesManagement
        "order" => Order::class,
        "order-item" => OrderItem::class,
        "invoice" => Invoice::class,
        "invoice-item" => InvoiceItem::class,
        "tax" => Tax::class,
        "tax-group" => TaxGroup::class,
        "customer" => BaseCustomer::class,
        "payment" => Payment::class,

        // SubscriptionsManagement
        "subscription" =>  Subscription::class,
        "plan" =>  Plan::class,
        "package" =>  Package::class,
        "advantage" =>  Advantage::class,
    ],

    // 📜 Liste des commandes Artisan à enregistrer automatiquement depuis le package
    "console_commands" => [
        CreateStaffCommand::class,
    ],

    // 🔗 Liste des modèles qui doivent interagir avec une organisation
    "models_interact_with_organization" => [
        // Cas avec relation BelongsToMany (pivot)
        User::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => UserHasOrganization::class,
        ],

        Staff::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => UserHasOrganization::class,
        ],

        /**
         * Cas simples : relations BelongsTo vers une organisation
         */
        User::class,
        Role::class,
        OtpCode::class,
        ContactForm::class,
        Setting::class,
        Media::class,
        Order::class,
        Invoice::class,
        Payment::class,
        Tax::class,
        TaxGroup::class,
        Customer::class,
        Plan::class,
        Package::class,
        Subscription::class,
    ],

    /**
     * ✍️ Liste des modèles qui doivent enregistrer l’auteur
     * Voir la configuration associée dans :
     * @see \config/eloquent-authorable.php
     */
    "models_has_authors" => [
        Organization::class ,
        Staff::class ,

        User::class ,
        Role::class ,
        Permission::class ,
        ContactForm::class,
        Setting::class,
        Media::class,
        Customer::class,
        Product::class,
        Order::class,
        OrderItem::class,
        Invoice::class,
        InvoiceItem::class,
        Tax::class,
        Payment::class,
        TaxGroup::class,
        Plan::class,
        Package::class,
        Subscription::class,

        Address::class,
    ]
];
