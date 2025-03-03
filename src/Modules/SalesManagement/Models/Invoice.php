<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;
use Kirago\BusinessCore\Support\Exceptions\NewIdCannotGeneratedException;
use Kirago\BusinessCore\Support\Helpers\PDFHelper;
use Illuminate\Support\Str;

class Invoice extends BaseInvoice
{

    use HasCustomPrimaryKey;

    protected string $table = "sales_mgt__invoices";




    public function refreshInvoice(): void
    {
        // TODO: Implement refreshInvoice() method.
    }

    public function items(): HasMany
    {
        // TODO: Implement items() method.
    }

    public function payments(): HasMany
    {
        // TODO: Implement payments() method.
    }

    public function order(): BelongsTo
    {
        // TODO: Implement order() method.
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
     * @throws NewIdCannotGeneratedException
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
                        ["name" => "created_at" , "value" => date("Y-m")],
                    ]
                ],
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

    public function recipient(): BelongsTo
    {
        // TODO: Implement recipient() method.
    }
}