<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use DateTime;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BasePaymentContract;
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
 * @property DateTime paied_at
 * @property int invoice_id
 */

abstract class BaseBcPayment extends BaseBcModel implements
    EventNotifiableContract,BasePaymentContract,GenerateUniqueValueContrat
{

    protected static function booted(){

        static::creating(function (self $payment) {
            $payment->generateUniqueValue();

            if (!$payment->paied_at){
                $payment->paied_at = now();
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