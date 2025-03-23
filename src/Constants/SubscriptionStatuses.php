<?php

namespace Kirago\BusinessCore\Constants;

enum SubscriptionStatuses : string
{

    case UNPROCESSED = 'UNPROCESSED'; // Non-Traitée
    case COMPLETED = 'COMPLETED'; // Confirmé
    case CANCELLED = 'CANCELLED'; // Annulé
    case UNDER_PROCCESS = 'UNDER_PROCCESS'; // En Attente de traitement

}