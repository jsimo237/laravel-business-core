<?php

namespace Kirago\BusinessCore\Constants;

enum PermissionsGroup : string
{
    case ROLE      = 'ROLE';
    case COMPANY   = 'COMPANY';
    case PAYMENT   = 'PAYMENT';
    case ORDER     = 'ORDER';
    case INVOICE   = 'INVOICE';
    case PRODUCT   = 'PRODUCT';
    case USER      = 'USER';
    case CUSTOMER  = 'CUSTOMER';
    case STOCK     = 'STOCK';
    case WAREHOUSE = 'WAREHOUSE';


    public function details(): array
    {
        return match ($this) {
            self::ROLE => ["description" => "Gestion des Rôles", "icon" => null,],
            self::COMPANY => ["description" => "Gestion des Companies", "icon" => null,],
            self::PAYMENT => ["description" => "Gestion des paiements", "icon" => null,],
            self::ORDER => ["description" => "Gestion des commandes", "icon" => null,],
            self::INVOICE => ["description" => "Gestion des factures", "icon" => null,],
            self::USER => ["description" => "Gestion des utilisateurs", "icon" => null,],
            self::CUSTOMER => ["description" => "Gestion des clients", "icon" => null,],
            self::STOCK => ["description" => "Gestion de stocks", "icon" => null,],
            self::PRODUCT => ["description" => "Gestion des produits", "icon" => null,],
            self::WAREHOUSE => ["description" => "Gestion des entrepots", "icon" => null,],
        };
    }

}