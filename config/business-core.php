<?php


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

return [

    "migrations" => [
        'sub-path' => "business-core",
    ],

    /*
     |--------------------------------------------------------------------------
     | Chemin de base des modules
     |--------------------------------------------------------------------------
     |
     | Cette valeur détermine le répertoire racine dans lequel le package doit
     | rechercher les fichiers de routes tels que `web.php` et `api.php`.
     | Vous pouvez la surcharger dans le fichier config/business-core.php
     | de votre application Laravel.
     |
     */
    'modules_path' => null,

];