<?php

namespace Kirago\BusinessCore\Modules\LocalizationManagement\Constants;

enum SettingsKeys : string
{

    case AMOUNT_CURRENCY = 'AMOUNT_CURRENCY';
    case AMOUNT_SEPARATOR = 'AMOUNT_SEPARATOR';
    case LOGOS = 'LOGOS';
    case GOOGLE_TAG_MANAGER = 'GOOGLE_TAG_MANAGER';
    case XPEEDY_CONFIG = 'XPEEDY_CONFIG';


    public static function allTypes(): array
    {
        return [
            'text',
            'number',
            'longText',
            'boolean',
            'select-single',
            'select-multiple',
            'object',
        ];
    }

    public function details(): array
    {
        /**
         * Exemples de structure pour le champ 'illustration'
         * 1) illustration => [
         *       'type' => "icon"
         *       'value' => "fa fa-usd"
         *     ]
         * 2) illustration => [
         *       'type' => "image"
         *       'value' => "https://the-image-url"
         *     ]
         */
        return match ($this) {

            self::AMOUNT_CURRENCY => [
                "description" => "La dévise affichée sur les montants",
                "type" => "text",
                "illustration" => null,
            ],

            self::AMOUNT_SEPARATOR => [
                "description" => "Séparateur de montants",
                "type" => "text",
                "illustration" => null
            ],
        };
    }

}