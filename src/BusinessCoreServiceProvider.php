<?php

namespace Kirago\BusinessCore;

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
use Laravel\Sanctum\Sanctum;

//use Illuminate\Database\Schema\Blueprint;

class BusinessCoreServiceProvider extends BaseServiceProvider {

    use RegisterCustomMacro,PublishesMigrations;

    public function register(){

        //$this->mergeConfigFrom(__DIR__.'/../config/xpeedy-models-manager.php', 'xpeedy-models-manager');
        //$this->mergeConfigFrom(__DIR__.'/../config/notification-manager.php', 'xpeedy-notification-manager');
        //$this->mergeConfigFrom(__DIR__.'/../config/eloquent-authorable.php', 'xpeedy-eloquent-authorable');
        //$this->mergeConfigFrom(__DIR__.'/../config/location.php', 'xpeedy-location');
        //$this->mergeConfigFrom(__DIR__ . '/../config/presets/permission.php', 'xpeedy-permission');

        //toutes le colonnes 'varchar' seront par defaut (255 caractères)
        Schema::defaultStringLength(255);

        //types par défaut pour les colonnes polymorphiques
        Builder::defaultMorphKeyType("ulid");

        Sanctum::ignoreMigrations();
    }

    public function boot(){

        $this->offerPublishing();

        $this->registerMacroHelpers();

        $this->loadMacro();

        $this->registerConsoleCommands();

        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
        }

        // Charger les routes API
       // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    protected function loadMacro(){
        /**
         * Types polymorphes personnalisés indique à Eloquent d'utiliser un nom personnalisé pour chaque
         * model au lieu du nom de la classe(Kirago\BusinessCore\Models\...)
         */
       // Relation::enforceMorphMap(config('business-core.morphs-map'));


        /**
         * Se produit lorsque l'app passe trop de temps (> 500ms) à interroger la bd au cours d'une seule requête
         */
        DB::whenQueryingForLongerThan(500, function (Connection $connection , QueryExecuted $query) {
            $userAgent = request()->userAgent();
            $bindings  = json_encode($query->bindings);
            $content   = "[SQL] {$query->sql} in {$query->time} s\n
                              [bindinds]: {$bindings}\n [userAgent]: {$userAgent} \n";
            write_log("queries-timeout",$content);
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
            $rule = Password::min(5);
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
        $this->publishes([
            __DIR__.'/../config/business-core.php' => config_path('business-core.php'),
        ], 'business-core')
        ;
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
        $this->registerMigrations(__DIR__."/../database/migrations");

        $this->runPackageMigrations();
    }


    protected function registerConsoleCommands(): void{
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Commands\Setup::class,
            Commands\Install\InstallPermission::class,
        ]);
    }


}
