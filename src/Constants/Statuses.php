<?php

namespace Kirago\BusinessCore\Constants;

enum Statuses : string
{

    // Statuts généraux
    case PENDING = 'PENDING'; // En attente d'action
    case APPROVED = 'APPROVED'; // A été approuvée
    case REJECTED = 'REJECTED'; // A été rejetée
    case CANCELLED = 'CANCELLED'; // A été annulée

    // Statuts des commandes
    case ORDER_PENDING   = 'ORDER_PENDING'; // La commande est en attente de traitement
    case ORDER_SHIPPED   = 'ORDER_SHIPPED'; // La commande a été expédiée
    case ORDER_DELIVERED = 'ORDER_DELIVERED'; // La commande a été livrée
    case ORDER_CANCELED  = 'ORDER_CANCELED'; // La commande a été annulé

    // Statuts de paiement
    case PAYMENT_PENDING = 'PAYMENT_PENDING'; // Le paiement est en attente
    case PAYMENT_COMPLETED = 'PAYMENT_COMPLETED'; // Le paiement a été effectué avec succès
    case PAYMENT_FAILED = 'PAYMENT_FAILED'; // Le paiement a échoué

    // Statuts de facturation
    case INVOICE_CREATED = 'INVOICE_CREATED'; // La facture a été générée
    case INVOICE_PAID = 'INVOICE_PAID'; // La facture a été réglée
    case INVOICE_OVERDUE = 'INVOICE_OVERDUE'; // La facture est en retard de paiement

    // Statuts des utilisateurs
    case USER_ACTIVE = 'USER_ACTIVE'; // L'utilisateur est actif
    case USER_SUSPENDED = 'USER_SUSPENDED'; // L'utilisateur a été suspendu
    case USER_BANNED = 'USER_BANNED'; // L'utilisateur a été banni


//    const DRAFT = "DRAFT"; // BROULLION
//    const CREATED = "CREATED"; // Crée
//    const OPENED = "OPENED"; // Ouvert
//    const ONGOING = "ONGOING"; // En Attente
//    const COMPLETED = "COMPLETED";
//    const STOPPED = "STOPPED";
//    const PENDING = "PENDING"; // En Cours
//    const UNPROCESSED = "UNPROCESSED"; // Non Traité
//    const UNDER_PROCESS = "UNDER_PROCESS"; // En Cours de Traitement
//    const FAILED = "FAILED"; // Echoué
//    const CANCELED = "CANCELED"; // Annulé
//    const APPROVED = "APPROVED"; // Approuvé
//    const INITIATED = "INITIATED"; // Initié
//    const REJECTED = "REJECTED"; // Rejeté
//    const ACCEPTED = "ACCEPTED"; // Accepté
//    const SUCCESSFUL = "SUCCESSFUL"; // Réussie



    /**
     * Retourne la couleur associée à un statut.
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'yellow',
            self::APPROVED => 'green',
            self::REJECTED => 'red',
            self::CANCELLED => 'red',

            self::ORDER_PENDING, self::USER_SUSPENDED => 'orange',
            self::ORDER_SHIPPED => 'blue',
            self::ORDER_DELIVERED => 'green',

            self::PAYMENT_PENDING => 'yellow',
            self::PAYMENT_COMPLETED => 'green',
            self::PAYMENT_FAILED => 'red',

            self::INVOICE_CREATED => 'yellow',
            self::INVOICE_PAID => 'green',
            self::INVOICE_OVERDUE => 'red',

            self::USER_ACTIVE => 'green',
            self::USER_BANNED => 'red',
        };
    }

}