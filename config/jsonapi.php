<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Root Namespace
    |--------------------------------------------------------------------------
    |
    | The root JSON:API namespace, within your application's namespace.
    | This is used when generating any class that does not sit *within*
    | a server's namespace. For example, new servers and filters.
    |
    | By default this is set to `JsonApi` which means the root namespace
    | will be `\App\JsonApi`, if your application's namespace is `App`.
    */
    'namespace' => 'App\\JsonApi\\V1',

    'jsonapi' => [
        'version' => null, // Désactive l'ajout de la version JSON:API
    ],

    /*
    |--------------------------------------------------------------------------
    | Servers
    |--------------------------------------------------------------------------
    |
    | A list of the JSON:API compliant APIs in your application, referred to
    | as "servers". They must be listed below, with the array key being the
    | unique name for each server, and the value being the fully-qualified
    | class name of the server class.
    */
    'servers' => [
        'v1' => \Kirago\BusinessCore\JsonApi\V1\Server::class,
    ],
];
