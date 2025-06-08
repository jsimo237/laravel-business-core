<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use DateTime;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BasePaymentContract;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;
use Kirago\BusinessCore\Support\Contracts\GenerateUniqueValueContrat;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property int id
 * @property string code
 * @property string note
 * @property float amount
 * @property BaseInvoiceContract invoice
 * @property string source_code
 * @property string source_reference
 * @property array<string, mixed> source_response
 * @property string status
 * @property DateTime paid_at
 * @property int invoice_id
 * @property string category
 * @property string method
 */

abstract class BasePayment extends BaseModel implements
    EventNotifiableContract,BasePaymentContract,GenerateUniqueValueContrat
{

    protected static function booted(){

        static::creating(function (self $payment) {
            $payment->generateUniqueValue();

            if (!$payment->paid_at){
                $payment->paid_at = now();
            }
        });

        static::saved(function (self $payment){
            $payment->handlePaymentCompleted();
        });
    }

    public function getObjectName(): string
    {
        return $this->code;
    }


    /************ Abstract functions ************/
    abstract public function refreshPayment() : void;

    abstract public function invoice() : BelongsTo;
    abstract public function order() : HasOneThrough;

    abstract public function getOrder() : BaseOrderContract;
    abstract public function getInvoice() : BaseInvoiceContract;

    abstract public function generateUniqueValue(string $field = "code") : void ;
}