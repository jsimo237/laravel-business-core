<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use Kirago\BusinessCore\Enums\Statuses;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BillableContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\ContainItemsContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\HasRecipient;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\WithOrderCapacities;
use Kirago\BusinessCore\Support\Contracts\EventNotifiableContract;
use Kirago\BusinessCore\Support\Contracts\GenerateUniqueValueContrat;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \Illuminate\Database\Eloquent\Collection $payments
 * @property Collection $items
 * @property array<string, mixed> $discounts
 * @property string $status
 * @property string $code
 * @property string $code_folio
 * @property string $invoice_type
 * @property bool $has_no_taxes
 * @property bool $is_opened
 */
abstract class BaseInvoice extends BaseModel implements
    EventNotifiableContract, GenerateUniqueValueContrat,
    ContainItemsContrat,BaseInvoiceContract,
    BillableContrat,HasRecipient
{

    use WithOrderCapacities;

    protected array $fillable = [
        'code',
        'expiration_time',
        'excerpt',
        'status',
        'has_no_taxes',
        'is_opened',
        'discounts',
        'invoice_type',
    ];

    protected array $dates = [
        'expiration_time',
    ];

    protected $casts = [
        'is_opened' => 'boolean',
        'discounts' => 'array',
    ];

    protected $attributes = [
        'status_code' => Statuses::INVOICE_CREATED,
       // 'invoice_type' =>  BaseOrder::INVOICING_TYPE_PRODUCT,
        'is_opened' =>  true,
    ];


    protected static function booted()
    {
        static::creating(function (self $invoice) {
            $invoice->generateUniqueValue();
        });

        static::saving(function (self $invoice) {
            $invoice->refreshInvoice();
        });

        self::saved(function (BaseInvoiceContract $invoice) {

            /**
             * @var BaseOrderContract
             */
            $order = $invoice->order;

            if ($order) {
                if (!$order->invoicing_type) {
                    $order->invoicing_type = BaseOrder::INVOICING_TYPE_PRODUCT;
                    $order->save();
                }
                if (blank($invoice->items)) {

                    foreach ($order->items as $item) {
                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->code = $item->code;
                        $invoiceItem->excerpt = $item->excerpt;
                        $invoiceItem->unit_price = $item->unit_price;
                        $invoiceItem->quantity = $item->quantity;
                        $invoiceItem->discount = $item->discount;
                        $invoiceItem->taxes = $item->taxes;
                        $invoiceItem->invoiceable()->associate($item->salesOrderable);
                        $invoiceItem->salesInvoice()->associate($invoice);
                        $invoiceItem->save();
                    }
                }
            }
        });

    }


    /************ Abstract functions ************/
    abstract public function refreshInvoice() : void;

    abstract public function items() : HasMany;

    abstract public function payments() : HasMany;

    abstract public function order() : BelongsTo;

    abstract public function recipient() : MorphTo;

    abstract public function handleInvoicePaied() :void;

    abstract public function send() :void;

    abstract public function generateUniqueValue(string $field = "code") : void ;

    abstract public function produceBillPDF() : array;

    /************ computing functions  ************/
}