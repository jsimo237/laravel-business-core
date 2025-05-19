<?php

use Kirago\BusinessCore\Modules\SecurityManagement\Constants\BcPermissions;
use Kirago\BusinessCore\Modules\SecurityManagement\Constants\PermissionsGroup;

return [

    // ROLE
    [
        "name" => BcPermissions::ROLE_CREATE->value,
        "description" => "Peut créer un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => BcPermissions::ROLE_UPDATE->value,
        "description" => "Peut modifier un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => BcPermissions::ROLE_DELETE->value,
        "description" => "Peut supprimer un rôle",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => BcPermissions::ROLE_VIEW_ANY->value,
        "description" => "Peut voir tous les rôles",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => BcPermissions::ROLE_VIEW_LIST->value,
        "description" => "Peut voir la liste des rôles",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],
    [
        "name" => BcPermissions::ROLE_VIEW_MODULE->value,
        "description" => "Peut accéder au module des rôles",
        "guard_name" => "api",
        "group" => PermissionsGroup::ROLE->value,
    ],

    // COMPANY
    [
        "name" => BcPermissions::ORGANIZATION_CREATE->value,
        "description" => "Peut créer une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => BcPermissions::ORGANIZATION_UPDATE->value,
        "description" => "Peut modifier une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => BcPermissions::ORGANIZATION_DELETE->value,
        "description" => "Peut supprimer une entreprise",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => BcPermissions::ORGANIZATION_VIEW_ANY->value,
        "description" => "Peut voir toutes les entreprises",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => BcPermissions::ORGANIZATION_VIEW_LIST->value,
        "description" => "Peut voir la liste des entreprises",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],
    [
        "name" => BcPermissions::ORGANIZATION_VIEW_MODULE->value,
        "description" => "Peut accéder au module des entreprises",
        "guard_name" => "api",
        "group" => PermissionsGroup::COMPANY->value,
    ],

    // USER
    [
        "name" => BcPermissions::USER_CREATE->value,
        "description" => "Peut créer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => BcPermissions::USER_UPDATE->value,
        "description" => "Peut modifier un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => BcPermissions::USER_DELETE->value,
        "description" => "Peut supprimer un utilisateur",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => BcPermissions::USER_VIEW_ANY->value,
        "description" => "Peut voir tous les utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => BcPermissions::USER_VIEW_LIST->value,
        "description" => "Peut voir la liste des utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],
    [
        "name" => BcPermissions::USER_VIEW_MODULE->value,
        "description" => "Peut accéder au module des utilisateurs",
        "guard_name" => "api",
        "group" => PermissionsGroup::USER->value,
    ],

    // CUSTOMER
    [
        "name" => BcPermissions::CUSTOMER_CREATE->value,
        "description" => "Peut créer un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => BcPermissions::CUSTOMER_UPDATE->value,
        "description" => "Peut modifier un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => BcPermissions::CUSTOMER_DELETE->value,
        "description" => "Peut supprimer un client",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => BcPermissions::CUSTOMER_VIEW_ANY->value,
        "description" => "Peut voir tous les clients",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => BcPermissions::CUSTOMER_VIEW_LIST->value,
        "description" => "Peut voir la liste des clients",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],
    [
        "name" => BcPermissions::CUSTOMER_VIEW_MODULE->value,
        "description" => "Peut accéder au module des clients",
        "guard_name" => "api",
        "group" => PermissionsGroup::CUSTOMER->value,
    ],

    // ORDER
    [
        "name" => BcPermissions::ORDER_CREATE->value,
        "description" => "Peut créer une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => BcPermissions::ORDER_UPDATE->value,
        "description" => "Peut modifier une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => BcPermissions::ORDER_DELETE->value,
        "description" => "Peut supprimer une commande",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],
    [
        "name" => BcPermissions::ORDER_VIEW_ANY->value,
        "description" => "Peut voir toutes les commandes",
        "guard_name" => "api",
        "group" => PermissionsGroup::ORDER->value,
    ],

    // INVOICE
    [
        "name" => BcPermissions::INVOICE_CREATE->value,
        "description" => "Peut créer une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => BcPermissions::INVOICE_UPDATE->value,
        "description" => "Peut modifier une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => BcPermissions::INVOICE_DELETE->value,
        "description" => "Peut supprimer une facture",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],
    [
        "name" => BcPermissions::INVOICE_VIEW_ANY->value,
        "description" => "Peut voir toutes les factures",
        "guard_name" => "api",
        "group" => PermissionsGroup::INVOICE->value,
    ],

    // PAYMENT
    [
        "name" => BcPermissions::PAYMENT_CREATE->value,
        "description" => "Peut créer un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => BcPermissions::PAYMENT_UPDATE->value,
        "description" => "Peut modifier un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => BcPermissions::PAYMENT_DELETE->value,
        "description" => "Peut supprimer un paiement",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],
    [
        "name" => BcPermissions::PAYMENT_VIEW_ANY->value,
        "description" => "Peut voir tous les paiements",
        "guard_name" => "api",
        "group" => PermissionsGroup::PAYMENT->value,
    ],

    // PRODUCT
    [
        "name" => BcPermissions::PRODUCT_CREATE->value,
        "description" => "Peut créer un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => BcPermissions::PRODUCT_UPDATE->value,
        "description" => "Peut mettre à jour un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => BcPermissions::PRODUCT_DELETE->value,
        "description" => "Peut supprimer un produit",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => BcPermissions::PRODUCT_VIEW_ANY->value,
        "description" => "Peut voir tous les produits",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],
    [
        "name" => BcPermissions::PRODUCT_VIEW_LIST->value,
        "description" => "Peut voir la liste des produits",
        "guard_name" => "api",
        "group" => PermissionsGroup::PRODUCT->value,
    ],

    // STOCK
    [
        "name" => BcPermissions::STOCK_CREATE->value,
        "description" => "Peut créer un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => BcPermissions::STOCK_UPDATE->value,
        "description" => "Peut mettre à jour un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => BcPermissions::STOCK_DELETE->value,
        "description" => "Peut supprimer un stock",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => BcPermissions::STOCK_VIEW_ANY->value,
        "description" => "Peut voir tous les stocks",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => BcPermissions::STOCK_VIEW_LIST->value,
        "description" => "Peut voir la liste des stocks",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],
    [
        "name" => BcPermissions::STOCK_VIEW_MODULE->value,
        "description" => "Peut voir le module de gestion des stocks",
        "guard_name" => "api",
        "group" => PermissionsGroup::STOCK->value,
    ],

    // WAREHOUSE
    [
        "name" => BcPermissions::WAREHOUSE_CREATE->value,
        "description" => "Peut créer un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => BcPermissions::WAREHOUSE_UPDATE->value,
        "description" => "Peut mettre à jour un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => BcPermissions::WAREHOUSE_DELETE->value,
        "description" => "Peut supprimer un entrepôt",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => BcPermissions::WAREHOUSE_VIEW_ANY->value,
        "description" => "Peut voir tous les entrepôts",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => BcPermissions::WAREHOUSE_VIEW_LIST->value,
        "description" => "Peut voir la liste des entrepôts",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
    [
        "name" => BcPermissions::WAREHOUSE_VIEW_MODULE->value,
        "description" => "Peut voir le module des entrepôts",
        "guard_name" => "api",
        "group" => PermissionsGroup::WAREHOUSE->value,
    ],
];
