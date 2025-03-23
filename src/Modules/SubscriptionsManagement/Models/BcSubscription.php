<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorpTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;
use Kirago\BusinessCore\Database\Factories\SubscriptionsManagement\SubscriptionFactory;
use Kirago\BusinessCore\Modules\BaseBcModel;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseInvoiceItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderItemContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\OrderableContrat;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrderItem;


/**
 * @property string reference
 * @property DateTime start_at
 * @property DateTime end_at
 * @property float amount
 * @property int|null package_id
 * @property string|null subscriber_id
 * @property string|null subscriber_type
 * @property mixed subscriber
 */
class BcSubscription extends BaseBcModel implements OrderableContrat{

    protected $table = "subscriptions_mgt__subscriptions";


    protected $appends = [
        'active',
    ];

    protected $casts = [
        'start_at' => "datetime",
        'end_at' => "datetime",
    ];

    protected static function newFactory(){
        return SubscriptionFactory::new();
    }



    //RELATIONS

    /**
     * @return MorpTo
     */
    public function subscriber(): MorpTo
    {
        return $this->morphTo( __FUNCTION__, "subscriber" );
    }

    /**
     * @return BelongsTo
     */
    public function package(){
        return $this->belongsTo(BcPackage::class,"package_id");
    }

    public function advantages(){
        return $this->hasManyThrough(
            Advantage::class,
            ''
        );
    }


    //SCOPES

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActives(Builder $query){
        $now = date("Y-m-d");
        return $query->whereDate("start_at","<=",$now)
                     ->whereDate("end_at",">=",$now);
    }

    //ACCESSORS
    public function getActiveAttribute(): bool{
        $now = Carbon::now();
        return ($this->start_at <= $now && $this->end_at >= $now);
    }


    public function getObjectName(): string
    {
       return $this->reference;
    }

    public function getOrder(): ?BaseOrderContract
    {
        return $this->order;
    }

    public function getInvoice(): ?BaseInvoiceContract
    {
        return $this->invoice;
    }

    public function getInvoiceItem(): ?BaseInvoiceItemContrat
    {
        return $this->invoiceItem;
    }

    public function getOrderItem(): ?BaseOrderItemContrat
    {
        return $this->orderItem;
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(
            BcInvoice::class,
            BcInvoiceItem::class,
            BcInvoiceItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
            'id',               // Clé primaire sur Invoice
            'id',               // Clé primaire sur Product
            'invoice_id'         // Clé étrangère sur InvoiceItem (vers Invoice)
        )
            ->where((new BcInvoiceItem)->getTable().".".BcInvoiceItem::MORPH_TYPE_COLUMN,(new static)->getMorphClass())
            ;
    }

    public function invoiceItem(): MorphOne
    {
        return $this->morphOne(
            BcInvoiceItem::class,
            BcInvoiceItem::MORPH_FUNCTION_NAME,
            BcInvoiceItem::MORPH_TYPE_COLUMN,
        );
    }

    public function order(): HasOneThrough
    {
        return $this->hasOneThrough(
            BcOrder::class,
            BcOrderItem::class,
            BcOrderItem::MORPH_ID_COLUMN,  // Clé étrangère sur InvoiceItem (vers Product)
            'id',               // Clé primaire sur Order
            'id',               // Clé primaire sur Product
            'order_id'         // Clé étrangère sur OrderItem (vers Order)
        )
            ->where((new BcOrderItem)->getTable().".".BcOrderItem::MORPH_TYPE_COLUMN,(new static)->getMorphClass())
            ;
    }

    public function orderItem(): MorphOne
    {
        return $this->morphOne(
            BcOrderItem::class,
            BcOrderItem::MORPH_FUNCTION_NAME,
            BcOrderItem::MORPH_TYPE_COLUMN,
        );
    }
}
