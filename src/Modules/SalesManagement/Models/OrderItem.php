<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\InvoiceableContract;



class OrderItem extends BaseOrderItem
{

    protected string $table = "sales_mgt__order_items";

    const MORPH_ID_COLUMN = "orderable_id";
    const MORPH_TYPE_COLUMN = "orderable_type";
    const MORPH_FUNCTION_NAME = "orderable";

    // relation
    /**
     * an invoiceitem belongs to an invoice
     */
    public function order(): Belongsto
    {
        return $this->belongsTo(Order::class,"order_id");
    }

    /**
     * an event belongs to a user
     */
    public function orderable(): Morphto
    {
        return $this->morphTo(
                    self::MORPH_FUNCTION_NAME,
                    self::MORPH_TYPE_COLUMN,
                    self::MORPH_ID_COLUMN
                );
    }

}