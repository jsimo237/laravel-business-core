<?php

namespace Kirago\BusinessCore\JsonApi\V1\OrganizationsManagement\Organizations;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema as JsonApiSchema;

class Schema extends JsonApiSchema {

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = BcOrganization::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 5;


    public static function type(): string {
        return 'organizations';
    }


    public function fields(): iterable {
        return [
            ID::make("id"),
            Str::make("name")->sortable(),
            Str::make('slug')->sortable(),
            Str::make('email')->sortable(),
            Str::make('phone')->sortable(),
            Str::make('description'),

          //  HasMany::make('settings')->type('settings')->readOnly(),
         //   BelongsTo::make('manager')->type('users')->readOnly(),

           // ...JsonApiHelper::datesFields(),
        ];
    }


    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array{
        return [
//            WhereIdIn::make($this),
           // WhereIn::make('author', 'author_id'),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator{
        return PagePagination::make();
    }

    /**
     * Build an index query for this resource.
     *
     * @param Request|null $request
     * @param Builder $query
     * @return Builder
     */
    public function indexQuery(?Request $request, Builder $query): Builder{
        if ($user = optional($request)->user()) {
//            return $query->where(function (Builder $q) use ($user) {
//                return $q->whereNotNull('published_at')->orWhere('author_id', $user->getKey());
//            });
        }

        return $query;
    }
}
