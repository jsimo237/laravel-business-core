<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Constants;

enum PaymentCategroies : string
{

    case MANUALLY = "MANUALLY";
    case AUTOMATIC = "AUTOMATIC";


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
            // ->mapWithKeys(fn($case) => [$case->value => $case->value])
            ->toArray();
    }
}
