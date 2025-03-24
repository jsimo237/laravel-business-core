<?php

namespace Kirago\BusinessCore\Constants;

enum SubscriptionStatuses : string
{

    case INIATED = 'INIATED'; // Initiée
    case UNPROCESSED = 'UNPROCESSED'; // Non-Traitée
    case COMPLETED = 'COMPLETED'; // Confirmée
    case CANCELLED = 'CANCELLED'; // Annulée
    case UNDER_PROCCESS = 'UNDER_PROCCESS'; // En Attente de traitement

}