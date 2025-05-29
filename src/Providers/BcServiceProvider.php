<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Schema\Builder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Validation\Rules\Password;
use Kirago\BusinessCore\Commands\CacheEvents;
use Kirago\BusinessCore\Commands\ClearEventsCache;
use Kirago\BusinessCore\Commands\FixPublishedNamespaces;
use Kirago\BusinessCore\Commands\Install\InstallCurrencies;
use Kirago\BusinessCore\Commands\Install\InstallPermissions;
use Kirago\BusinessCore\Commands\Install\InstallRoleSuperAdmin;
use Kirago\BusinessCore\Commands\PublishCoreFolders;
use Kirago\BusinessCore\Commands\Setup;
use Laravel\Sanctum\Sanctum;

//use Illuminate\Database\Schema\Blueprint;

class BcServiceProvider extends BaseServiceProvider {

    use RegisterCustomMacro,PublishesMigrations,
        RegisterMiddlewares,RegisterViews,RegisterEvents;

    public function register(){

        //toutes le colonnes 'varchar' seront par defaut (255 caractères)
        Schema::defaultStringLength(191);

        //types par défaut pour les colonnes polymorphiques
        Builder::defaultMorphKeyType("ulid");

       // Sanctum::ignoreMigrations();

        $this->registerEvents();
    }

    public function boot(){

        $this->offerPublishing();

        $this->registerMacroHelpers();

        $this->loadMacro();

        $this->registerConsoleCommands();

        $this->mergePackageConfigsFiles();

        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
        }

        $this->bootWithMiddlewares();
        $this->bootWithViews();
        $this->bootWithViewsComponents();
        // Charger les routes API
       // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->registerListeners();
    }



    protected function mergePackageConfigsFiles(){

        $this->mergeConfigFrom(__DIR__.'/../../config/business-core.php', 'bc-config');
        $this->mergeConfigFrom(__DIR__.'/../../config/eloquent-has-many-deep.php', 'eloquent-has-many-deep');
        $this->mergeConfigFrom(__DIR__.'/../../config/permission.php', 'permission-config');
        $this->mergeConfigFrom(__DIR__.'/../../config/media-library.php', 'bc-config-permission');
        //        $this->mergeConfigFrom(__DIR__.'/../config/notification-manager.php', 'laravel-notifications');
        $this->mergeConfigFrom(__DIR__.'/../../config/sanctum.php', 'sanctum-config');
        $this->mergeConfigFrom(__DIR__.'/../../config/activitylog.php', 'activitylog-config');
        $this->mergeConfigFrom(__DIR__.'/../../config/xpeedy-service.php', 'xpeedy-service');
        $this->mergeConfigFrom(__DIR__.'/../../config/eloquent-authorable.php', 'eloquent-authorable');
//        $this->mergeConfigFrom(__DIR__.'/../config/location.php', 'bc-config-location');



    }

    protected function loadMacro(){
        /**
         * Types polymorphes personnalisés indique à Eloquent d'utiliser un nom personnalisé pour chaque
         * model au lieu du nom de la classe(Kirago\BusinessCore\Models\...)
         */
        Relation::enforceMorphMap(config("business-core.morphs_map") ?? []);


        /**
         * Se produit lorsque l'app passe trop de temps (> 500ms) à interroger la bd au cours d'une seule requête
         */
        DB::whenQueryingForLongerThan(500, function (Connection $connection , QueryExecuted $query) {
            $userAgent = request()->userAgent();
            $bindings  = json_encode($query->bindings);
            $content   = "[SQL] {$query->sql} in {$query->time} s\n
                              [bindinds]: {$bindings}\n [userAgent]: {$userAgent} \n";
            write_log("sql-queries",$content);
        });

        /**
         * Si l'affichage dans requetes sql en console est activé
         */
        if (env('APP_DISPLAY_QUERIES_IN_CONSOLE',false)){
            /*ecoute chaque requete entrante dans la bd*/
            DB::listen(function ($query) {
                $userAgent = request()->userAgent();
                $bindings  = json_encode($query->bindings);
                $content   = "[SQL] {$query->sql} in {$query->time} s\n
                              [bindinds]: {$bindings}\n [userAgent]: {$userAgent} \n";

                /**
                 * Imprime le message sur le terminal courant en exécution (s'il est ouvert)
                 */
                file_put_contents('php://stderr', $content);
            });
        }


        //defini la validation par défaut des mots de passe
        Password::defaults(function (){
            $rule = Password::min(6);
            return $this->app->isProduction()
                        ? $rule->mixedCase()->uncompromised()
                        : $rule;
        });


        /**
         * Supprimer certaine migrations
         */
        if (Schema::hasTable("migrations")){
            DB::table("migrations")
                ->whereIn('migration',[
                    "2025_31_17_141516_add_fields_authorable",
                    "2025_31_17_141516_add_fields_dates",
                    "2025_31_17_141516_add_fields_organization_id",
                    "2025_31_17_141516_add_fields_is_active",
                    "2023_06_01_012858_add_fields_to_application_table",
                ])
                ->delete();
        }

    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string{
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);
       // dd($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR);

        return Collection::make([$this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR])
          //  ->flatMap(fn ($path) => $filesystem->glob($path.'*_'.$migrationFileName))
           // ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            //->first();
        ;
    }

    private function configurePublishing(){
        $this->publishes(
                [
                    __DIR__.'/../../config/business-core.php' => config_path('business-core.php'),
                 //   __DIR__.'/../config/eloquent-authorable.php' => config_path('eloquent-authorable.php'),
                    __DIR__.'/../../config/location.php' => config_path('location.php'),
                    __DIR__.'/../../config/permission.php' => config_path('permission.php'),
                    __DIR__.'/../../config/notification-manager.php' => config_path('notification-manager.php'),
                    __DIR__.'/../../config/eloquent-has-many-deep.php' => config_path('eloquent-has-many-deep.php'),
                    __DIR__.'/../../config/media-library.php' => config_path('media-library.php'),
                    __DIR__.'/../../config/sanctum.php' => config_path('sanctum.php'),
                    __DIR__.'/../../config/activitylog.php' => config_path('activitylog.php'),
                    __DIR__.'/../../config/jsonapi.php' => config_path('jsonapi.php'),
                 ],
                'bc-config-all'
            ) ;

        $this->publishes(
                [
                    __DIR__.'/../../config/business-core.php' => config_path('business-core.php'),
                ],
                'bc-config'
            ) ;

        $this->publishes([
            __DIR__.'/../../data/currencies.php' => config_path('bc-data/currencies.php'),
            __DIR__.'/../../data/permissions.php' => config_path('bc-data/permissions.php'),
        ], 'bc-data') ;

        // ✅ Nouvelle directive : publier les modèles depuis src/Modules
//        $this->publishes([
//            __DIR__.'/../Modules' => base_path("app/Modules"),
//            __DIR__."/../Support" => base_path("app/Support"),
//            __DIR__."/../JsonApi" => base_path("app/JsonApi"),
//        ], 'bc-src');

        $this->publishes([
          //  __DIR__.'/../../resources/views/' => $this->app->resourcePath('views/vendor/mail'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/business-core')
        ], 'bc-resources-views');
    }

    protected function offerPublishing(): void{
        if (! $this->app->runningInConsole()) {
            return;
        }

        // function not available and 'publish' not relevant in Lumen
        if (! function_exists('config_path')) {
            return;
        }

        // $this->loadMigrationsFrom('');

        $this->loadMigrationsFrom([
            database_path('migrations'),
            database_path('migrations/business-core'),

            //__DIR__ . '/database/migrations'
        ]);
        $this->registerMigrations(__DIR__."/../../database/migrations");

        $this->publishModulesMigrations();
    }

    protected function registerConsoleCommands(): void{
        if (!$this->app->runningInConsole()) {
            return;
        }

        if ($commands = config("business-core.console_commands") ?? []){
            $this->commands($commands);
        }

        $this->commands([
            Setup::class,
            InstallCurrencies::class,
            InstallRoleSuperAdmin::class,
            InstallPermissions::class,
            FixPublishedNamespaces::class,
            PublishCoreFolders::class,
            CacheEvents::class,
            ClearEventsCache::class,
        ]);

    }


    protected function registerEvents(){
        $this->app->register(BcEventServiceProvider::class);

    }
    protected function registerFacades(){
        // 🔁 Enregistre une seule instance (singleton) de BusinessCoreManager dans le conteneur de services
        // Cela permet d'y accéder via une façade ou l'injection de dépendance
        $this->app->singleton(\Kirago\BusinessCore\BusinessCoreManager::class);

        // 🧱 Récupère l'alias loader de Laravel (permet d’enregistrer des alias de classes)
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        // 🏷️ Enregistre un alias "BcRoute" pour qu’on puisse utiliser la façade plus facilement partout dans le code
        // Exemple : BcRoute::discover()
        $loader->alias('BusinessCore', \Kirago\BusinessCore\Facades\BusinessCore::class);

    }
}
