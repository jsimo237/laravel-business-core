<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Customers\Filters;

use Illuminate\Database\Eloquent\Builder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Customer;
use LaravelJsonApi\Eloquent\Contracts\Filter;

class SubscriptionFilter implements Filter {

    public function key(): string {
        return 'subscription';
    }

    public function apply( $query,mixed $value): Builder
    {
      return  $query->whereHas('subscription', function (Builder $q) use ($value) {
            $q->whereIn('subscriber_id', (array) $value)
                ->where('subscriber_type',(new Customer)->getMorphClass());
        });
    }

    public function isSingular(): bool
    {
       return true;
    }
}
