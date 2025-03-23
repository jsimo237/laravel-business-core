<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;


use Kirago\BusinessCore\Constants\BillingInformations;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\ModelIsBillableTo;

/**
 * @property string billing_entity_type
 */
trait ModelHasBillingInformations
{


    public static function bootModelHasBillingInformations(){

        static::saving(function (ModelIsBillableTo $model) {
            if ($model->billing_entity_type === BillingInformations::TYPE_INDIVIDUAL->value) {
                $model->billing_company_name = 'N/A';
            } elseif ($model->billing_entity_type === BillingInformations::TYPE_COMPANY->value) {
                $model->billing_firstname = 'N/A';
                $model->billing_lastname = 'N/A';
            }
        });
    }




    /**
     * getBillingInformations
     */
    public function getBillingInformations(): array
    {
        return [
            'billing_entity_type' => $this->billing_entity_type,
            'billing_company_name' => $this->billing_company_name ?? 'NOT_DEFINED',
            'billing_firstname' => $this->billing_firstname ?? 'NOT_DEFINED',
            'billing_lastname' => $this->billing_lastname ?? 'NOT_DEFINED',
            'billing_country' => $this->billing_country ?? 'NOT_DEFINED',
            'billing_state' => $this->billing_state ?? 'NOT_DEFINED',
            'billing_city' => $this->billing_city ?? 'NOT_DEFINED',
            'billing_zipcode' => $this->billing_zipcode ?? 'NOT_DEFINED',
            'billing_address' => $this->billing_address ?? 'NOT_DEFINED',
            'billing_email' => $this->billing_email ?? 'NOT_DEFINED',
        ];
    }
}