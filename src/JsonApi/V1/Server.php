<?php

namespace Kirago\BusinessCore\JsonApi\V1;

use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Document\JsonApi;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer{


    /**
     * @inheritDoc
     * @return JsonApi
     */
    public function jsonApi(): JsonApi
    {
        return new JsonApi(null);
    }

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';


    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void{


       // Auth::shouldUse((new Learner)->guardName());
       Auth::shouldUse('sanctum');

//        Post::creating(static function (Post $post): void {
//            $post->author()->associate(Auth::user());
//        });
    }


    protected function allSchemas(): array {
        return  [
            \App\JsonApi\V1\SubscriptionsManagement\Subscriptions\Schema::class,

            \App\JsonApi\V1\OrganizationsManagement\Organizations\Schema::class,
            \App\JsonApi\V1\OrganizationsManagement\Staffs\Schema::class,

            \App\JsonApi\V1\SalesManagement\Products\Schema::class,
            \App\JsonApi\V1\SalesManagement\Orders\Schema::class,
            \App\JsonApi\V1\SalesManagement\OrderItems\Schema::class,
            \App\JsonApi\V1\SalesManagement\Invoices\Schema::class,
            \App\JsonApi\V1\SalesManagement\InvoiceItems\Schema::class,
            \App\JsonApi\V1\SalesManagement\Payments\Schema::class,


            \App\JsonApi\V1\SecurityManagement\Users\Schema::class,
           // \App\JsonApi\V1\SecurityManagement\Roles\Schema::class,
           // \App\JsonApi\V1\SecurityManagement\Permissions\Schema::class,

            \App\JsonApi\V1\SubscriptionsManagement\Packages\Schema::class,
            \App\JsonApi\V1\SubscriptionsManagement\Plans\Schema::class,
        ];
    }

    /**
     * Obtenez le nom du serveur.
     *
     * @return string
     */
    public function name(): string{
        return 'v1';
    }
}
