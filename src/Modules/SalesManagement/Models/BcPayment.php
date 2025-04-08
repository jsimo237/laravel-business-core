<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;



use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Support\Constants\Statuses;
use Kirago\BusinessCore\Support\Exceptions\BcNewIdCannotGeneratedException;

class BcPayment extends BaseBcPayment
{

    protected $table = "sales_mgt__payments";

    protected $fillable = [
        'date',
        'code',
        'status',
        'note',
        'amount',
        'source_code',
        'source_reference',
        'souce_data',
        'from_payment_id',
    ];

    protected $dates = [
        'paid_at',
    ];

    protected $casts = [
        "source_response" => "array"
    ];




    /**
     * @throws BcNewIdCannotGeneratedException
     */
    public function generateUniqueValue(string $field = "code"): void
    {
        $organisation = $this->getOrganization();
        // les options supplémentaire applicable à l'opération de decompte
        $options = [
            "key" => $field,
            "prefix" => "PAY".$organisation->getKey(),
            "suffix" => date("Ym"),
            "separator" => "-",
            "charLengthNextId" => 0,
            "uniquesBy" => [
                ["column" => "organization_id" , "value" => $organisation->getKey()]
            ],
            "countBy" => [
                ["column" => "organization_id" , "value" => $organisation->getKey()],
                ["column" => "created_at" , "value" => date("Y-m")],
            ]
        ];

        $this->$field = newId(static::class, $options);

    }



    /**
     * @throws BcNewIdCannotGeneratedException
     */
    public function refreshPayment(): void
    {
        if (!$this->code)
        {
            $this->generateUniqueValue();
        }

    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(BcInvoice::class,"invoice_id");
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                        BcOrder::class,  // Modèle cible (Order)
                        BcInvoice::class, // Modèle intermédiaire (Invoice)
                        'id', // Clé primaire d'Invoice (intermédiaire)
                        'id', // Clé primaire d'Order (final)
                        'invoice_id', // Clé étrangère dans Payment qui pointe vers Invoice
                        'order_id' // Clé étrangère dans Invoice qui pointe vers Order
                    );
    }

    public function handlePaymentCompleted(): void
    {
        $precision = env("BC_MATH_SCALE", 2) ;

        /**
         * @var BcInvoice $invoice
         */
        $invoice = $this->invoice;
        if ($this->status === Statuses::PAYMENT_COMPLETED->value) {

            $totalAmountFmt = number_format($invoice->getTotalAmount(), $precision, '.', '');
            $totalPaidFmt = number_format($invoice->getTotalPaied(), $precision, '.', '');

            if (bccomp($totalAmountFmt, $totalPaidFmt) == 0) {
                $invoice->handleInvoicePaied();
            }
        }

    }

    public function getOrder(): BaseOrderContract
    {
        return $this->order;
    }

    public function getInvoice(): BaseInvoiceContract
    {
        return $this->invoice;
    }
}