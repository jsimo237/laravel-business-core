<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Constants;

enum PaymentStatuses : string
{

    case DRAFT = 'DRAFT'; //
    case VALIDATED = 'VALIDATED'; //
    case CANCELLED = 'CANCELLED'; //
    case REFUNDED = 'REFUNDED'; //

}