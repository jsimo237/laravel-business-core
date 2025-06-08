<?php

namespace Kirago\BusinessCore\Modules\SubscriptionsManagement\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Kirago\BusinessCore\Modules\BaseModel;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseInvoiceContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\InvoiceItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\OrderItemContract;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BillableItem;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Invoiceable;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Orderable;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\OrderItem;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\InteractWithInvoiceItemsCapacities;
use Kirago\BusinessCore\Modules\SalesManagement\Traits\InteractWithOrdertemsCapacities;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Constants\SubscriptionStatuses;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Factories\SubscriptionFactory;
use Kirago\BusinessCore\Support\Exceptions\NewIdCannotGeneratedException;


/**
 * @property string id
 * @property string reference
 * @property DateTime initiated_at
 * @property DateTime completed_at
 * @property DateTime start_at
 * @property DateTime end_at
 * @property float amount
 * @property string status
 * @property int|null package_id
 * @property Package package
 * @property string|null subscriber_id
 * @property string|null subscriber_type
 * @property mixed subscriber
 */
class Subscription extends BaseModel implements BillableItem {

    use InteractWithInvoiceItemsCapacities,
        InteractWithOrdertemsCapacities;

    protected $table = "subscriptions_mgt__subscriptions";

    protected $casts = [
        'start_at' => "datetime",
        'end_at' => "datetime",
    ];

    protected static function newFactory(){
        return SubscriptionFactory::new();
    }

    protected static function booted()
    {
        static::creating(/**
         * @throws NewIdCannotGeneratedException
         */ function (Subscription $subscription) {
            $subscription->generateReference();
        });

        static::saving(function (Subscription $subscription) {
          //  $status = $subscription->status;
            $subscription->status ??= SubscriptionStatuses::INITIATED->value;

            if($subscription->status === SubscriptionStatuses::INITIATED->value){
                $subscription->initiated_at ??= now();
            }
            if($subscription->status === SubscriptionStatuses::COMPLETED->value){
                $subscription->completed_at ??= now();
            }

            if (!$subscription->amount && $subscription->package){
                $subscription->amount = $subscription->package->price;
            }
        });

    }


        //RELATIONS

    /**
     * @return MorphTo
     */
    public function subscriber(): MorphTo
    {
        return $this->morphTo(__FUNCTION__);
    }

    /**
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class,"package_id");
    }

    public function advantages(){
        return $this->hasManyThrough(
            Advantage::class,

        );
    }


    /**
     * @throws NewIdCannotGeneratedException
     */
    public function generateReference(): void
    {
        $organisation = $this->getOrganization();
        // les options supplémentaire applicable à l'opération de decompte
        $options = [
            "key" => "reference",
            "prefix" => "SUB".$organisation?->getKey(),
            "suffix" => date("Ym"),
            "separator" => "-",
            "charLengthNextId" => 3,
            "uniquesBy" => [
                ["column" => "organization_id" , "value" => $organisation->getKey()]
            ],
            "countBy" => [
                    ["column" => "organization_id" , "value" => $organisation->getKey()],
                    ["column" => "created_at" , "value" => date("Y-m")],
                ]
        ];

        $this->reference = newId(static::class, $options);
    }

    //SCOPES

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActives(Builder $query): Builder
    {
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

    public function getItemId(): string|int
    {
        return $this->getKey();
    }

    public function getSku(): string
    {
        return $this->reference;
    }

    public function getName(): string
    {
        return $this->reference;
    }

    public function getNote(): ?string
    {
        return null;
    }

    public function getProductId(): string
    {
        return $this->getKey();
    }

}
