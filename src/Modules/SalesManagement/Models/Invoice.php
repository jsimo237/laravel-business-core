<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\PaymentStatuses;
use Kirago\BusinessCore\Support\Exceptions\NewIdCannotGeneratedException;
use Kirago\BusinessCore\Support\Helpers\PDFHelper;
use Illuminate\Support\Str;

class Invoice extends BaseInvoice
{

    protected $table = "sales_mgt__invoices";

    public function refreshInvoice(): void
    {
        // TODO: Implement refreshInvoice() method.
    }

    public function items(): HasMany
    {
       return $this->hasMany(InvoiceItem::class,"invoice_id");
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class,"invoice_id");
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,"order_id");
    }

    public function handleInvoicePaid(): void
    {
        // TODO: Implement handleInvoicePaied() method.
    }

    public function send(): void
    {
        // TODO: Implement send() method.
    }

    /**
     * @throws NewIdCannotGeneratedException
     */
    public function generateUniqueValue(string $field = "code"): void
    {
        $organisation = $this->getOrganization();
        // les options supplémentaire applicable à l'opération de decompte
        $options = [
            "key" => $field,
            "prefix" => "INV".$organisation->getKey(),
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

    public function produceBillPDF(): array
    {
        return PDFHelper::generateStream(
                            Str::slug($this->code),
                            [
                            "view" => [
                                "file" => "pdf.invoices.print",
                                "data" => [
                                    "invoice" => $this
                                ],
                            ]

                        ]);
    }

    public function recipient(): MorphTo
    {
        return $this->morphTo( __FUNCTION__);
    }

    public function getTotalPaid(): float
    {
       return $this->payments()
                    ->where('status',PaymentStatuses::VALIDATED->value)
                    ->sum("amount");
    }

    public function getTotalRemaining(): float
    {
       return $this->getTotalAmount() - $this->getTotalPaid();
    }
}