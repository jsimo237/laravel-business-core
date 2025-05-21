<?php

namespace Kirago\BusinessCore\JsonApi\V1\OrganizationsManagement\Organizations\Filters;


use LaravelJsonApi\Eloquent\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;

class OrganizationFilter implements Filter {

    public function key(): string {
        return 'organization';
    }

    public function apply( $query,mixed $value): Builder
    {
      return  $query->where('organization_id', $value);
    }

    public function isSingular(): bool
    {
       return true;
    }
}
