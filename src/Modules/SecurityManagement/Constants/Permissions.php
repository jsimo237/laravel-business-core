<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Constants;

enum Permissions : string
{

    // ORGANIZATION
    case ORGANIZATION_CREATE = "organization-create";
    case ORGANIZATION_UPDATE = "organization-update";
    case ORGANIZATION_DELETE = "organization-delete";
    case ORGANIZATION_VIEW_ANY = "organization-view-any";
    case ORGANIZATION_VIEW = "organization-view";
    case ORGANIZATION_VIEW_MODULE = "organization-view-module";

    case STAFF_CREATE = "staff-create";
    case STAFF_UPDATE = "staff-update";
    case STAFF_DELETE = "staff-delete";
    case STAFF_VIEW_ANY = "staff-view-any";
    case STAFF_VIEW = "staff-view";
    case STAFF_VIEW_MODULE = "staff-view-module";

    // ROLE
    case ROLE_CREATE = "role-create";
    case ROLE_UPDATE = "role-update";
    case ROLE_DELETE = "role-delete";
    case ROLE_VIEW_ANY = "role-view-any";
    case ROLE_VIEW    = "role-view";
    case ROLE_VIEW_MODULE = "role-view-module";

    // USER
    case USER_CREATE = "user-create";
    case USER_UPDATE = "user-update";
    case USER_DELETE = "user-delete";
    case USER_VIEW_ANY = "user-view-any";
    case USER_VIEW = "user-view";
    case USER_VIEW_MODULE = "user-view-module";

    // CUSTOMER
    case CUSTOMER_CREATE = "customer-create";
    case CUSTOMER_UPDATE = "customer-update";
    case CUSTOMER_DELETE = "customer-delete";
    case CUSTOMER_VIEW_ANY = "customer-view-any";
    case CUSTOMER_VIEW = "customer-view";
    case CUSTOMER_VIEW_MODULE = "customer-view-module";

    // ORDER
    case ORDER_CREATE = "order-create";
    case ORDER_UPDATE = "order-update";
    case ORDER_DELETE = "order-delete";
    case ORDER_VIEW_ANY = "order-view-any";
    case ORDER_VIEW = "order-view";
    case ORDER_VIEW_MODULE = "order-view-module";

    // PAYMENT
    case PAYMENT_CREATE = "payment-create";
    case PAYMENT_UPDATE = "payment-update";
    case PAYMENT_DELETE = "payment-delete";
    case PAYMENT_VIEW_ANY = "payment-view-any";
    case PAYMENT_VIEW = "payment-view";
    case PAYMENT_VIEW_MODULE = "payment-view-module";

    // INVOICE
    case INVOICE_CREATE = "invoice-create";
    case INVOICE_UPDATE = "invoice-update";
    case INVOICE_DELETE = "invoice-delete";
    case INVOICE_VIEW_ANY = "invoice-view-any";
    case INVOICE_VIEW = "invoice-view";
    case INVOICE_VIEW_MODULE = "invoice-view-module";

    // PRODUCT
    case PRODUCT_CREATE = "product-create";
    case PRODUCT_UPDATE = "product-update";
    case PRODUCT_DELETE = "product-delete";
    case PRODUCT_VIEW_ANY = "product-view-any";
    case PRODUCT_VIEW = "product-view";
    case PRODUCT_VIEW_MODULE = "product-view-module";

    // STOCK
    case STOCK_CREATE = "stock-create";
    case STOCK_UPDATE = "stock-update";
    case STOCK_DELETE = "stock-delete";
    case STOCK_VIEW_ANY = "stock-view-any";
    case STOCK_VIEW = "stock-view";
    case STOCK_VIEW_MODULE = "stock-view-module";

    // WAREHOUSE
    case WAREHOUSE_CREATE = "warehouse-create";
    case WAREHOUSE_UPDATE = "warehouse-update";
    case WAREHOUSE_DELETE = "warehouse-delete";
    case WAREHOUSE_VIEW_ANY = "warehouse-view-any";
    case WAREHOUSE_VIEW = "warehouse-view";
    case WAREHOUSE_VIEW_MODULE = "warehouse-view-module";

    //PACKAGE
    case PACKAGE_CREATE = "package-create";
    case PACKAGE_UPDATE = "package-update";
    case PACKAGE_DELETE = "package-delete";
    case PACKAGE_VIEW_ANY = "package-view-any";
    case PACKAGE_VIEW = "package-view";
    case PACKAGE_VIEW_MODULE = "package-view-module";

    //SUBSCRIPTIONS
    case SUBSCRIPTION_CREATE = "subscription-create";
    case SUBSCRIPTION_UPDATE = "subscription-update";
    case SUBSCRIPTION_DELETE = "subscription-delete";
    case SUBSCRIPTION_VIEW_ANY = "subscription-view-any";
    case SUBSCRIPTION_VIEW = "subscription-view";
    case SUBSCRIPTION_VIEW_MODULE = "subscription-view-module";

    // SETTING
    case SETTING_CREATE = "settings-create";
    case SETTING_UPDATE = "settings-update";
    case SETTING_DELETE = "settings-delete";
    case SETTING_VIEW_ANY = "settings-view-any";
    case SETTING_VIEW = "settings-view";
    case SETTING_VIEW_MODULE = "settings-view-module";

    //CATEGORY
    case CATEGORY_CREATE = "category-create";
    case CATEGORY_UPDATE = "category-update";
    case CATEGORY_DELETE = "category-delete";
    case CATEGORY_VIEW_ANY = "category-view-any";
    case CATEGORY_VIEW = "category-view";
    case CATEGORY_VIEW_MODULE = "category-view-module";

    public function details(): array
    {
        return match ($this) {
            self::PRODUCT_CREATE => ["description" => "...",],

        };
    }

    /**
     * Retourne les valeurs des enums sous forme de tableau
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Retourne tous les services avec leurs détails
     * @return array
     */
    public static function all(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->details()])
            // ->mapWithKeys(fn($case) => [$case->value => $case->value])
            ->toArray();
    }

}
