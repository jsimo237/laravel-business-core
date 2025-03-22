<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;



use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Kirago\BusinessCore\Enums\Statuses;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Support\Exceptions\NewIdCannotGeneratedException;

class Payment extends BasePayment
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
     * @throws NewIdCannotGeneratedException
     */
    public function generateUniqueValue(string $field = "code"): void
    {
        $organisation = $this->getOrganization();
        // les options supplémentaire applicable à l'opération de decompte
        $options = [
            "prefix" => "PAY".$organisation->getKey(),
            "suffixe" => date("Ym"),
            "separator" => "-",
            "count_by" => [
                "column" => [
                    ["name" => "organization_id" , "value" => $organisation->getKey()],
                    ["name" => "created_at" , "value" => date("Y-m")],
                ]
            ],
        ];

        $this->$field = newId(static::class, $options);

    }


    /**
     * @throws NewIdCannotGeneratedException
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
        return $this->belongsTo(Invoice::class,"invoice_id");
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
                        Order::class,  // Modèle cible (Order)
                        Invoice::class, // Modèle intermédiaire (Invoice)
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
         * @var Invoice $invoice
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