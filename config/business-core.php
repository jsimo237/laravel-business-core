<?php

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kirago\BusinessCore\Modules\CoresManagement\Models\BcMedia;
use Kirago\BusinessCore\Modules\CoresManagement\Models\Notification;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcAddress;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCity;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcCountry;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcQuarter;
use Kirago\BusinessCore\Modules\LocalizationManagement\Models\BcState;
use Kirago\BusinessCore\Modules\OrganizationManagement\Commands\CreateStaffCommand;
use Kirago\BusinessCore\Modules\OrganizationManagement\Middlewares\EnsureRequestHasOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcContactForm;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcSetting;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcPayment;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcProduct;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTax;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcTaxGroup;
use Kirago\BusinessCore\Modules\SecurityManagement\Middlewares\EnsureAuthGuardHeaderIsPresent;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcOtpCode;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcPermission;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcRole;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\UserHasOrganization;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcAdvantage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPackage;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcPlan;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;

return [

    // 🔧 Active ou non la personnalisation des fichiers du package
    'customization' => false,

    'middlewares' => [
        'has-auth-guard-header' => EnsureAuthGuardHeaderIsPresent::class,
        'has-organization' => EnsureRequestHasOrganization::class
    ],

    // 🧑‍💼 Définition des classes utilisables pour l'authentification selon le rôle
    "authenticables" => [
        'customer' => BcCustomer::class,
        'staff' => BcStaff::class,
    ],

    // 📁 Sous-dossier dans le dossier de migrations où seront placées celles du package
    "migrations_subpath" => "business-core",

    // 🔄 Mapping morphologique pour les relations morphTo dans les modèles
    "morphs_map" => [
        // OrganizationManagement
        "organization" => BcOrganization::class,
        "staff" => BcStaff::class,

        // CoreManagement
        "media" =>  BcMedia::class,
        "notification" => Notification::class,

        // SecurityManagement
        "role" => BcRole::class,
        "permission" => BcPermission::class,
        "user" => BcUser::class,
        "otp-code" =>  BcOtpCode::class,

        // LocalizationManagement
        "country" => BcCountry::class,
        "state" => BcState::class,
        "city" => BcCity::class,
        "quarter" => BcQuarter::class,

        // SalesManagement
        "order" => BcOrder::class,
        "order-item" => BcOrderItem::class,
        "invoice" => BcInvoice::class,
        "invoice-item" => BcInvoiceItem::class,
        "tax" => BcTax::class,
        "tax-group" => BcTaxGroup::class,
        "customer" => BaseBcCustomer::class,
        "payment" => BcPayment::class,

        // SubscriptionsManagement
        "subscription" =>  BcSubscription::class,
        "plan" =>  BcPlan::class,
        "package" =>  BcPackage::class,
        "advantage" =>  BcAdvantage::class,
    ],

    // 📜 Liste des commandes Artisan à enregistrer automatiquement depuis le package
    "console_commands" => [
        CreateStaffCommand::class,
    ],

    // 🔗 Liste des modèles qui doivent interagir avec une organisation
    "models_interact_with_organization" => [
        // Cas avec relation BelongsToMany (pivot)
        BcUser::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => UserHasOrganization::class,
        ],

        BcStaff::class => [
            "type" => BelongsToMany::class,
            "related_column_name" => "user_id",
            "related_model" => UserHasOrganization::class,
        ],

        /**
         * Cas simples : relations BelongsTo vers une organisation
         */
        BcUser::class,
        BcRole::class,
        BcOtpCode::class,
        BcContactForm::class,
        BcSetting::class,
        BcMedia::class,
        BcOrder::class,
        BcInvoice::class,
        BcPayment::class,
        BcTax::class,
        BcTaxGroup::class,
        BcCustomer::class,
        BcPlan::class,
        BcPackage::class,
        BcSubscription::class,
    ],

    /**
     * ✍️ Liste des modèles qui doivent enregistrer l’auteur
     * Voir la configuration associée dans :
     * @see \config/eloquent-authorable.php
     */
    "models_has_authors" => [
        BcOrganization::class ,
        BcStaff::class ,

        BcUser::class ,
        BcRole::class ,
        BcPermission::class ,
        BcContactForm::class,
        BcSetting::class,
        BcMedia::class,
        BcCustomer::class,
        BcProduct::class,
        BcOrder::class,
        BcOrderItem::class,
        BcInvoice::class,
        BcInvoiceItem::class,
        BcTax::class,
        BcPayment::class,
        BcTaxGroup::class,
        BcPlan::class,
        BcPackage::class,
        BcSubscription::class,

        BcAddress::class,
    ]
];
