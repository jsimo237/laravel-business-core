<?php

namespace Kirago\BusinessCore\Support\Constants;

enum BcOrderStatuses : string
{

    case DRAFT = 'DRAFT'; // La facture a été générée
    case VALIDATED = 'VALIDATED'; // La facture a été validé
    case CANCELLED = 'CANCELLED'; // La facture a été annulé

}