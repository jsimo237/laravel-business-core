<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Xpeedy base url
    |--------------------------------------------------------------------------
    |
    | Représente l'url de base ou est hébergé l'api xpeedy
    |
    */

    'base_url' => env("XPEEDY_BASE_URL", "https://api.wallet.collections.xpeedy.app/api/v1"),

    /*
     |--------------------------------------------------------------------------
     | Xpeedy base url
     |--------------------------------------------------------------------------
     |
     | Représente l'identifiant unique du porte feuille virtuel
     |
     */

    'api_id' => env('XPEEDY_API_ID', "xxxxxxxxxxxx"),


    /*
      |--------------------------------------------------------------------------
      | [Xpeedy-Collection] api key (wallet login)
      |--------------------------------------------------------------------------
      |
      | Représente l'identifiant de connexion au porte feuille virtuel
      |
      */
    'api_key' => env('XPEEDY_API_KEY', "xxxxxxxxxxxx"),


    /*
     |--------------------------------------------------------------------------
     | [Xpeedy-Collection] api secret (wallet password)
     |--------------------------------------------------------------------------
     |
     | Représente le mot de passe d'accès au porte feuille virtuelle
     |
     */
    'api_secret' => env('XPEEDY_API_SECRET', "xxxxxxxxxxxx"),

];
