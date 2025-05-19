<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Customers\Filters;

use Illuminate\Database\Eloquent\Builder;
use LaravelJsonApi\Eloquent\Contracts\Filter;

class SearchByEmailOrPhoneFilter implements Filter {

    protected ?string $name = 'search'; // Nom du filtre dans l'URL

    public function key(): string {
        return 'search';
    }

    public function apply( $query,mixed $value): Builder
    {

        return $query->where(function ($q) use ($value) {
                        $q->where('email', $value)
                            ->orWhere('phone', $value);
                    })
                  ->limit(1); // Récupère le premier correspondant
    }

    public function isSingular(): bool
    {
       return true;
    }
}
