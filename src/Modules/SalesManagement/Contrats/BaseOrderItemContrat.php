<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;

/**
 * @property string|int $id
 * @property string $code
 * @property int|float $quantity
 * @property float $unit_price
 * @property string $note
 * @property float $discount
 * @property array<string, mixed> $taxes
 * @property BaseOrderContract $order
 * @property BaseInvoiceContract $invoice
 * @property BaseInvoiceContract $invoiceable
 * @property OrderableContrat $orderable
 */
interface BaseOrderItemContrat
{

    public function getItemTotalAmount () : ?float;

    public function getItemSubTotalAmount() : ?float;

    public function getTaxableBaseAmount() : ?float;

    public function getItemTaxes() : ?array;

    public function getItemDiscountAmount() : ?float;

    public function getOrganization() : BcOrganization;

    public function getOrderable() : ?OrderableContrat;

    public function getOrder() : ?BaseOrderContract;


    public function invoice() : HasOneThrough;

    public function orderable() : MorphTo;

    public function order () : BelongsTo;


}