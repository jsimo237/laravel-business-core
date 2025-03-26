<?php
namespace Kirago\BusinessCore\Constants;

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
    public function baseRules(): array
    {
        return [
            'billing_entity_type' => ['required', Rule::in(self::values())], // ✅
            'billing_company_name' => ['required', 'string', 'min:1', 'max:128'], // ✅ min:1 au lieu de min:0
            'billing_firstname' => ['required', 'string', 'min:1', 'max:128'],
            'billing_lastname' => ['required', 'string', 'min:1', 'max:128'],
            'billing_country' => ['required', 'string', 'min:1', 'max:128'],
            'billing_state' => ['required', 'string', 'min:1', 'max:128'],
            'billing_city' => ['required', 'string', 'min:1', 'max:128'],
            'billing_zipcode' => ['required', 'string', 'min:1', 'max:128'],
            'billing_address' => ['nullable', 'string', 'max:128'], // ✅ "min:0" inutile
            'billing_email' => ['required', 'email'],
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
