<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirago\BusinessCore\Modules\HasCustomPrimaryKey;

class Order extends BaseOrder
{
    use HasCustomPrimaryKey;

    protected string $table = "sales_mgt__orders";




    public function refreshOrder(): void
    {
        // TODO: Implement refreshOrder() method.
    }

    public function items(): HasMany
    {
        // TODO: Implement items() method.
    }

    public function invoice(): BelongsTo
    {
        // TODO: Implement invoice() method.
    }

    public function generateUniqueValue(string $field = "code"): void
    {
        // TODO: Implement generateUniqueValue() method.
    }

    public function send(): void
    {
        // TODO: Implement send() method.
    }
}