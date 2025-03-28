<?php

namespace Kirago\BusinessCore\Constants;

enum PaymentSource : string
{

    case XPEEDY = 'XPEEDY';

    case CASH = 'CASH';

    case DEBIT = 'DEBIT';

    case VISA = 'VISA';

    case MASTERCARD = 'MASTERCARD';

    case AMEX = 'AMEX';

    case SOTRANSFERT = 'E_TRANSFERT';

    case CHECK = 'CHECK';

    case OTHER = 'OTHER';

    case UNKNOWN = 'UNKNOWN';



}