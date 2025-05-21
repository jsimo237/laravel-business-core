<?php

namespace Kirago\BusinessCore\JsonApi\V1\SalesManagement\Customers;

use Kirago\BusinessCore\Support\Helpers\JsonApiHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcCustomer;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema as JsonApiSchema;

class Schema extends JsonApiSchema {

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = BcCustomer::class;

    /**
     * The maximum include path depth.
     *
     * @var int
     */
    protected int $maxDepth = 10;


    public static function type(): string {
        return 'customers';
    }


    public function fields(): iterable {
        return [
            ID::make(),
            Str::make("member_type","type")->readOnly(),
            Str::make("licence_key")->readOnly(),
            Str::make("password")->hidden(),


            //  ID::make()->resolveUsing(fn ($member) => $member->code), // Définit "code" comme ID
            ...JsonApiHelper::personnableFields(),

            Boolean::make('has_credentials')
                ->extractUsing(function (Member $member){
                    $user = $member->user;
                    return $user && !empty($user->{$user->getPasswordField()});
                }),

           // Str::make("key")->resolveUsing(fn ($member) => $member->code),
           // HasOne::make('membership')->type('memberships'), // si défini en morphone
            HasMany::make('subscriptions')->type('subscriptions'), // si défini en morphmany
            HasMany::make('orders')->type('orders'), // si défini en morphmany
            HasMany::make('invoices')->type('invoices'), // si défini en morphmany
            HasOne::make('user')->type('users'), // si défini en morphone
            HasOne::make('package')->type('packages'), // si défini en morphone
          //  MorphTo::make('memberships')->types('memberships','packages'),
//               ->inverse()

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
//            Where::make("member_type","type")
//                ->apply(function (Builder $query,mixed $value) : Builder{
//                return $query->where('type',$value);
//            }),

            new MemberShipFilter(),
          //  new SearchByEmailOrPhoneFilter(),
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
     * @param \Kirago\BusinessCore\JsonApi\V1\SalesManagement\Customers\Request|null $request
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
