<?php

namespace Kirago\BusinessCore\Support\Helpers;

use Carbon\Carbon;

final class BcSettingHelper
{

    public static function formatValueAsTring($value): string
    {
        if((is_array($value) or is_object($value))){
           $value = json_encode($value);
        }

        return (string) $value;
    }

}