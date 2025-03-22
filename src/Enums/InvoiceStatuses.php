<?php

namespace Kirago\BusinessCore\Enums;

enum InvoiceStatuses : string
{

    case CREATED = 'CREATED'; // La facture a été générée
    case VALIDATED = 'VALIDATED'; // La facture a été validé
    case CANCELLED = 'CANCELLED'; // La facture a été annulé
    case PAID = 'PAID'; // La facture a été réglée
    case OVERDUE = 'OVERDUE'; // La facture est en retard de paiement

}