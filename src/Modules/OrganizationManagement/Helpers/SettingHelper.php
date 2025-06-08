<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Helpers;

use Carbon\Carbon;

final class SettingHelper
{

    public static function formatValueAsTring($value): string
    {
        if((is_array($value) or is_object($value))){
           $value = json_encode($value);
        }

        return (string) $value;
    }

}