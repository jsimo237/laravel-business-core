<?php

namespace Kirago\BusinessCore\JsonApi\V1\SubscriptionsManagement\Subscriptions;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOneThrough;
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
    public static string $model = BcSubscription::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 10;


    public static function type(): string {
        return 'subscriptions';
    }


    public function fields(): iterable {
        return [

            ID::make("id"),

            Str::make("reference")->sortable()->readOnly(),
            Number::make("amount")->sortable()->readOnly(),
            Str::make('status'),
            Boolean::make('active'),

            DateTime::make('initiated_at')->sortable()->readOnly(),
            DateTime::make('completed_at')->sortable()->readOnly(),
            DateTime::make('start_at')->sortable()->readOnly(),
            DateTime::make('end_at')->sortable()->readOnly(),

         //   HasOne::make("subscriber")->type('partners'), // si défini en morphone

           // MorphTo::make('subscriber',"subscriber")->types('members'),
           // MorphTo::make('invoice',"invoice")->type('invoices'),
           // MorphTo::make('order',"order")->type('orders'),
            BelongsTo::make('package')->type('packages'),
            HasOneThrough::make('invoice')->type('invoices'),
            HasOneThrough::make('order')->type('orders'),

            ...JsonApiHelper::commonsFields(),
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
     * @param \App\JsonApi\V1\SubscriptionsManagement\Subscriptions\Request|null $request
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
