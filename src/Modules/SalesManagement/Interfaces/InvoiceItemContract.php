<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;

/**
 * @property string|int id
 * @property string code
 * @property int|float quantity
 * @property float unit_price
 * @property string note
 * @property float discount
 * @property array<string, mixed> taxes
 * @property BaseOrderContract order
 * @property BaseInvoiceContract invoice
 * @property Invoiceable invoiceable
 */
interface InvoiceItemContract
{

    public function getItemTotalAmount () : ?float;

    public function getItemSubTotalAmount() : ?float;

    public function getTaxableBaseAmount() : ?float;

    public function getItemTaxes() : ?array;

    public function getItemDiscountAmount() : ?float;

    public function getOrganization() : ?Organization;

    public function getInvoiceable() : ?Invoiceable;

    public function getInvoice() : ?BaseInvoiceContract;


    public function invoice() : BelongsTo;

    public function invoiceable() : MorphTo;

    public function order () : HasOneThrough;


}