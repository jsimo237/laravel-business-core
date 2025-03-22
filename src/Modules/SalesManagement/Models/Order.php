<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;
use Kirago\BusinessCore\Support\Exceptions\NewIdCannotGeneratedException;

class Order extends BaseOrder
{
    use HasCustomPrimaryKey;

    protected $table = "sales_mgt__orders";

    protected $fillable = [
        'code',
        'expired_at',
        'note',
        'status',
        'has_no_taxes',
        'discounts',
    ];

    protected $dates = [
        'expired_at',
        'processed_at',
    ];

    protected $casts = [
        "discounts" => "array"
    ];


    public function refreshOrder(): void
    {
        // TODO: Implement refreshOrder() method.
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class,"order_id");
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class,"order_id");
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
                    ["name" => "organization_id" , "value" => $organisation->getKey()],
                    ["name" => "created_at" , "value" => date("Y-m")],
                ]
            ],
        ];

        $this->$field = newId(static::class, $options);
    }

    public function send(): void
    {
        // TODO: Implement send() method.
    }

    public function recipient(): MorphTo
    {
        return $this->morphTo(Customer::class,"recipient");
    }
}