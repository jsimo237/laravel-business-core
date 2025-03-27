<?php

namespace Kirago\BusinessCore\Support\Constants;

enum BcPaymentStatuses : string
{

    case DRAFT = 'DRAFT'; //
    case VALIDATED = 'VALIDATED'; //
    case CANCELLED = 'CANCELLED'; //
    case REFUNDED = 'REFUNDED'; //

}