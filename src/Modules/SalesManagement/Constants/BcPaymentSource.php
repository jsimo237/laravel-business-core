<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Constants;

enum BcPaymentSource : string
{

    case XPEEDY = 'XPEEDY';

    case CASH = 'CASH';

    case DEBIT = 'DEBIT';

    case VISA = 'VISA';

    case MASTERCARD = 'MASTERCARD';

    case AMEX = 'AMEX';

    case E_TRANSFERT = 'E_TRANSFERT';

    case CHECK = 'CHECK';

    case OTHER = 'OTHER';

    case UNKNOWN = 'UNKNOWN';


    public function details(): array
    {
        return match ($this){

                default =>  []
        };
    }


    /**
     * Retourne les valeurs des enums sous forme de tableau
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Retourne tous les services avec leurs détails
     * @return array
     */
    public static function all(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->details()])
            ->toArray();
    }

}