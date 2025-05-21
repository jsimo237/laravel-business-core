<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Constants;

enum BcSubscriptionStatuses : string
{

    case INITIATED = 'INITIATED'; // Initiée
    case UNPROCESSED = 'UNPROCESSED'; // Non-Traitée
    case COMPLETED = 'COMPLETED'; // Confirmée
    case CANCELLED = 'CANCELLED'; // Annulée
    case UNDER_PROCCESS = 'UNDER_PROCCESS'; // En Attente de traitement

}