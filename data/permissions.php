<?php

use Kirago\BusinessCore\Modules\SecurityManagement\Constants\Permissions;
use Kirago\BusinessCore\Modules\SecurityManagement\Constants\PermissionsGroup;

return [

    // ROLE
    [
        "name" => Permissions::ROLE_CREATE->value,
        "description" => "Peut créer un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => Permissions::ROLE_UPDATE->value,
        "description" => "Peut modifier un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => Permissions::ROLE_DELETE->value,
        "description" => "Peut supprimer un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => Permissions::ROLE_VIEW_ANY->value,
        "description" => "Peut voir tous les rôles",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => Permissions::ROLE_VIEW->value,
        "description" => "Peut voir un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => Permissions::ROLE_VIEW_MODULE->value,
        "description" => "Peut accéder au module des rôles",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],

    // ORGANIZATION
    [
        "name" => Permissions::ORGANIZATION_CREATE->value,
        "description" => "Peut créer une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => Permissions::ORGANIZATION_UPDATE->value,
        "description" => "Peut modifier une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => Permissions::ORGANIZATION_DELETE->value,
        "description" => "Peut supprimer une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => Permissions::ORGANIZATION_VIEW_ANY->value,
        "description" => "Peut voir toutes les entreprises",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => Permissions::ORGANIZATION_VIEW->value,
        "description" => "Peut voir une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => Permissions::ORGANIZATION_VIEW_MODULE->value,
        "description" => "Peut accéder au module des entreprises",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],

    // STAFFS
    [
        "name" => Permissions::STAFF_CREATE->value,
        "description" => "Peut créer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],
    [
        "name" => Permissions::STAFF_UPDATE->value,
        "description" => "Peut modifier un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],
    [
        "name" => Permissions::STAFF_DELETE->value,
        "description" => "Peut supprimer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],
    [
        "name" => Permissions::STAFF_VIEW_ANY->value,
        "description" => "Peut voir tous les utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],
    [
        "name" => Permissions::STAFF_VIEW->value,
        "description" => "Peut voir un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],
    [
        "name" => Permissions::STAFF_VIEW_MODULE->value,
        "description" => "Peut accéder au module des staffs",
        "guard_name" => "api",
        "group" => PermissionsGroup::STAFF->value,
    ],

    // USER
    [
        "name" => Permissions::USER_CREATE->value,
        "description" => "Peut créer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => Permissions::USER_UPDATE->value,
        "description" => "Peut modifier un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => Permissions::USER_DELETE->value,
        "description" => "Peut supprimer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => Permissions::USER_VIEW_ANY->value,
        "description" => "Peut voir tous les utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => Permissions::USER_VIEW->value,
        "description" => "Peut voir un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => Permissions::USER_VIEW_MODULE->value,
        "description" => "Peut accéder au module des utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],

    // CUSTOMER
    [
        "name" => Permissions::CUSTOMER_CREATE->value,
        "description" => "Peut créer un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => Permissions::CUSTOMER_UPDATE->value,
        "description" => "Peut modifier un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => Permissions::CUSTOMER_DELETE->value,
        "description" => "Peut supprimer un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => Permissions::CUSTOMER_VIEW_ANY->value,
        "description" => "Peut voir tous les clients",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => Permissions::CUSTOMER_VIEW->value,
        "description" => "Peut voir un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => Permissions::CUSTOMER_VIEW_MODULE->value,
        "description" => "Peut accéder au module des clients",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],

    // ORDER
    [
        "name" => Permissions::ORDER_CREATE->value,
        "description" => "Peut créer une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => Permissions::ORDER_UPDATE->value,
        "description" => "Peut modifier une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => Permissions::ORDER_DELETE->value,
        "description" => "Peut supprimer une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => Permissions::ORDER_VIEW_ANY->value,
        "description" => "Peut voir toutes les commandes",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],

    // INVOICE
    [
        "name" => Permissions::INVOICE_CREATE->value,
        "description" => "Peut créer une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => Permissions::INVOICE_UPDATE->value,
        "description" => "Peut modifier une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => Permissions::INVOICE_DELETE->value,
        "description" => "Peut supprimer une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => Permissions::INVOICE_VIEW_ANY->value,
        "description" => "Peut voir toutes les factures",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],

    // PAYMENT
    [
        "name" => Permissions::PAYMENT_CREATE->value,
        "description" => "Peut créer un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => Permissions::PAYMENT_UPDATE->value,
        "description" => "Peut modifier un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => Permissions::PAYMENT_DELETE->value,
        "description" => "Peut supprimer un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => Permissions::PAYMENT_VIEW_ANY->value,
        "description" => "Peut voir tous les paiements",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],

    // PRODUCT
    [
        "name" => Permissions::PRODUCT_CREATE->value,
        "description" => "Peut créer un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => Permissions::PRODUCT_UPDATE->value,
        "description" => "Peut mettre à jour un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => Permissions::PRODUCT_DELETE->value,
        "description" => "Peut supprimer un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => Permissions::PRODUCT_VIEW_ANY->value,
        "description" => "Peut voir tous les produits",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => Permissions::PRODUCT_VIEW->value,
        "description" => "Peut voir un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],

    // STOCK
    [
        "name" => Permissions::STOCK_CREATE->value,
        "description" => "Peut créer un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => Permissions::STOCK_UPDATE->value,
        "description" => "Peut mettre à jour un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => Permissions::STOCK_DELETE->value,
        "description" => "Peut supprimer un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => Permissions::STOCK_VIEW_ANY->value,
        "description" => "Peut voir tous les stocks",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => Permissions::STOCK_VIEW->value,
        "description" => "Peut voir un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => Permissions::STOCK_VIEW_MODULE->value,
        "description" => "Peut voir le module de gestion des stocks",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],

    // WAREHOUSE
    [
        "name" => Permissions::WAREHOUSE_CREATE->value,
        "description" => "Peut créer un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => Permissions::WAREHOUSE_UPDATE->value,
        "description" => "Peut mettre à jour un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => Permissions::WAREHOUSE_DELETE->value,
        "description" => "Peut supprimer un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => Permissions::WAREHOUSE_VIEW_ANY->value,
        "description" => "Peut voir tous les entrepôts",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => Permissions::WAREHOUSE_VIEW->value,
        "description" => "Peut voir un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => Permissions::WAREHOUSE_VIEW_MODULE->value,
        "description" => "Peut voir le module des entrepôts",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
];
