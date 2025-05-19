<?php

namespace Kirago\BusinessCore\JsonApi\V1\OrganizationsManagement\Staffs;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcStaff;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema as JsonApiSchema;

class Schema extends JsonApiSchema {

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = BcStaff::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 10;


    public static function type(): string {
        return 'staffs';
    }


    public function fields(): iterable {
        return [
            ID::make(),
            ...JsonApiHelper::personnableFields(),

            Boolean::make('is_active')->sortable(),
           // Boolean::make('is_2fa_enabled')->sortable(),
            ArrayList::make('privileges')->sortable(),

         //   MorphTo::make('entity')->type('memberships')->readOnly(),
           // HasMany::make('orders')->type('orders')->readOnly(),
            //HasMany::make('invoices')->type('invoices')->readOnly(),
            //HasMany::make('permissions')->type('permissions')->readOnly(),
           // HasMany::make('roles')->type('roles')->readOnly(),
          //  MorphTo::make('entity')->types('members',"staffs"),

            ...JsonApiHelper::commonsFields()
        ];
    }


    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array{
        return [
            WhereIdIn::make($this),
          //  WhereIn::make('author', 'created_by'),
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
