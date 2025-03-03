<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Traits;

use Kirago\BusinessCore\Modules\SalesManagement\Contrats\HasRecipient;

trait ConfigureRecipient
{

    public static function bootConfigureRecipient(){

        static::saved(function (HasRecipient $model) {

            if (  $recipient = $model->recipient){
                $model->forceFill([
                            "billing_firstname" => $recipient->firstname ?? "N/A,N/A",
                            "billing_lastname" => $recipient->lastname ?? "N/A,N/A",
                            "billing_country" => $recipient->country ?? "N/A,N/A",
                            "billing_state" => $recipient->state ?? "N/A,N/A",
                            "billing_city" => $recipient->city ?? "N/A,N/A",
                            "billing_zipcode" => $recipient->zipcode ?? "N/A,N/A",
                            "billing_address" => $recipient->address ?? "N/A,N/A",
                            "billing_email" => $recipient->email ?? "N/A,N/A",
                        ])
                        ->saveQuietly();
            }
        });
    }
}