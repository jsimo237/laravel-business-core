<?php

namespace Kirago\BusinessCore\Support\Constants;

enum BcInvoiceStatuses : string
{

    case CREATED = 'CREATED'; // La facture a été générée
    case VALIDATED = 'VALIDATED'; // La facture a été validé
    case CANCELLED = 'CANCELLED'; // La facture a été annulé
    case PAID = 'PAID'; // La facture a été réglée
    case OVERDUE = 'OVERDUE'; // La facture est en retard de paiement

}