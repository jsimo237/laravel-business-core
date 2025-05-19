<?php

namespace Kirago\BusinessCore\Support\Helpers;

use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;

final class JsonApiHelper
{

    public static function datesFields(): array
    {
        return [
            DateTime::make('created_at')->sortable()->readOnly(),
            DateTime::make('updated_at')->sortable()->readOnly(),
        ];
    }

    public static function commonsFields(): array
    {
        return [
            BelongsTo::make('organization')->type('organizations')->readOnly(),
            ...self::datesFields(),
        ];
    }

    public static function billingInformationsFields(): array
    {
        return [
            Str::make("billing_entity_type"),
            Str::make("billing_company_name"),
            Str::make("billing_firstname"),
            Str::make("billing_lastname"),
            Str::make("billing_country"),
            Str::make("billing_state"),
            Str::make("billing_city"),
            Str::make("billing_zipcode"),
            Str::make("billing_address"),
            Str::make("billing_email"),
            Str::make("billing_email"),
        ];
    }

    public static function personnableFields(): array
    {
        return [
            Str::make("firstname")->sortable(),
            Str::make('lastname')->sortable(),
            Str::make('fullname')->sortable(),
            Str::make('username')->sortable(),
            Str::make('initials'),
            Str::make('email')->sortable(),
            Str::make('phone')->sortable(),
        ];
    }

}
