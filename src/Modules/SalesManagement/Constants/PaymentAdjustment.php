<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Constants;

enum PaymentAdjustment : string
{

    case ADJUSTMENT_TYPE_PERCENTAGE = "PERCENTAGE";
    case ADJUSTMENT_TYPE_FIXED = "FIXED";


    public function details(): array
    {
        return [];
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
