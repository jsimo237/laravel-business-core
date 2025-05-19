<?php
namespace Kirago\BusinessCore\Modules\SalesManagement\Constants;

use Illuminate\Validation\Rule;

enum BcBillingInformations: string
{
    case TYPE_INDIVIDUAL = 'INDIVIDUAL';
    case TYPE_COMPANY = 'COMPANY';

    public static function modelBillingInformationFields(): array
    {
        return [
            'billing_entity_type',
            'billing_company_name',
            'billing_firstname',
            'billing_lastname',
            'billing_country',
            'billing_state',
            'billing_city',
            'billing_zipcode',
            'billing_address',
            'billing_email',
        ];
    }

    /**
     * @return string[][]
     */
    public static function baseRules(): array
    {
        return [
            'billing_entity_type' => ['nullable', Rule::in(self::values())], // ✅
            'billing_company_name' => ['nullable', 'string', 'min:1', 'max:128'], // ✅ min:1 au lieu de min:0
            'billing_firstname' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_lastname' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_country' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_state' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_city' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_zipcode' => ['nullable', 'string', 'min:1', 'max:128'],
            'billing_address' => ['nullable', 'string', 'max:128'], // ✅ "min:0" inutile
            'billing_email' => ['nullable', 'email'],
        ];
    }

    /**
     * Retourne les valeurs des enums sous forme de tableau
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
