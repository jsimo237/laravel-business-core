<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;
use Kirago\BusinessCore\Support\Exceptions\BcNewIdCannotGeneratedException;
use Kirago\BusinessCore\Support\Helpers\BcPDFHelper;
use Illuminate\Support\Str;

class BcInvoice extends BaseBcInvoice
{

    use HasCustomPrimaryKey;

    protected $table = "sales_mgt__invoices";




    public function refreshInvoice(): void
    {
        // TODO: Implement refreshInvoice() method.
    }

    public function items(): HasMany
    {
       return $this->hasMany(BcInvoiceItem::class,"invoice_id");
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BcPayment::class,"invoice_id");
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(BcOrder::class,"order_id");
    }

    public function handleInvoicePaied(): void
    {
        // TODO: Implement handleInvoicePaied() method.
    }

    public function send(): void
    {
        // TODO: Implement send() method.
    }

    /**
     * @throws BcNewIdCannotGeneratedException
     */
    public function generateUniqueValue(string $field = "code"): void
    {
        $organisation = $this->getOrganization();
        // les options supplémentaire applicable à l'opération de decompte
        $options = [
             "prefix" => "INV".$organisation->getKey(),
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

    public function produceBillPDF(): array
    {
        return BcPDFHelper::generateStream(
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
        return $this->morphTo(BcCustomer::class,"recipient");
    }

    public function getTotalPaied(): float
    {
        // TODO: Implement getTotalPaied() method.
    }
}