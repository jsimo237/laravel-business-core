<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Orderable;


class BcOrderItem extends BaseOrderItem
{

    protected $table = "sales_mgt__order_items";

    const MORPH_ID_COLUMN = "orderable_id";
    const MORPH_TYPE_COLUMN = "orderable_type";
    const MORPH_FUNCTION_NAME = "orderable";

    // relation
    /**
     * an invoiceitem belongs to an invoice
     */
    public function order(): Belongsto
    {
        return $this->belongsTo(BcOrder::class,"order_id");
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

    public function getOrder(): ?BaseOrder
    {
        return $this->order;
    }

    public function getOrderable(): ?Orderable
    {
        return $this->orderable;
    }

    public function getOrganization(): BcOrganization
    {
        return $this->order?->getOrganization();
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(
                        BcInvoice::class, // Modèle cible (Invoice)
                        BcOrder::class,   // Modèle intermédiaire (Order)
                        'id',           // Clé primaire de Order (intermédiaire)
                        'order_id',     // Clé étrangère dans Invoice (vers Order)
                        'order_id',     // Clé étrangère dans OrderItem (vers Order)
                        'id'            // Clé primaire de Order (intermédiaire)
                    );

    }

    public function getObjectName(): string
    {
       return $this->code;
    }
}