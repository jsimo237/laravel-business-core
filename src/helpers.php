<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kirago\BusinessCore\Constants\Settings;
use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Kirago\BusinessCore\Support\Exceptions\BcNewIdCannotGeneratedException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Stevebauman\Location\Facades\Location;


if (!function_exists('format_amount')) {

    function format_amount(float|int $amount , string|bool $currency = "", ?string $separator = null): string
    {

        $organization = currentOrganization();
        if(isset($currency) and is_bool($currency) and $currency == true){
            $currency = $organization->getSettingOf(Settings::AMOUNT_CURRENCY,"XAF");
        }

        $separator ??= $organization->getSettingOf(Settings::AMOUNT_CURRENCY," ");
        if (!empty($currency)){
            $currency = " ".$currency;
        }
        return number_format(ceil($amount),0,".",$separator).$currency ;
    }
}



if (! function_exists('format_with_char')) {
    /**
     * @param mixed $value la valeur à completer
     * @param int $limit la longueur du la chaine complétée
     * @param string $added_char [optional] le caractère à completer
     * @param int $position la position du caractère completer dans la chaine de retour
     * @return string
     */
    function format_with_char(mixed $value, int $limit = 5, string $added_char = "0", int $position = STR_PAD_LEFT): string
    {
        return str_pad((string) $value, $limit, $added_char, $position);
    }
}

if (! function_exists('format_exception_message')) {
    function format_exception_message($exception): string
    {
        return $exception->getMessage()." file = ".$exception->getFile()."| line = ".$exception->getLine()."| trace = ".$exception->getTraceAsString();
    }
}

if (!function_exists('write_log')) {

    /**
     * @param $directory
     * @param $message
     * @param string $type
     * @param string $name
     * @return bool
     */
    function write_log($directory, $message, string $type = 'info', string $name = "action"): bool
    {

        if ($message instanceof Exception){
            $message = format_exception_message($message);
        }
        if (is_array($message) or is_object($message)){
            $message = json_encode($message);
        }
        if (!$directory or !$name && (!empty($message))){
            Log::error($message);
        }else{
            $logger = new Logger(Str::Slug($name));
            $path = storage_path("/logs/$directory");

            /*fichier journal qui sera crée de journal d'erreur*/
            $log_file = "$path/log.log";

            /*Génération de journal d'erreur*/
            $logger = $logger->pushHandler(new RotatingFileHandler($log_file));

            $logger->{$type}($message);

            if ($directory){
                $files = File::allFiles($path);
                $deletable = env("APP_DELETE_LOGS_FILES_AFTER","3days");

                foreach ($files as $file) {
                    $realPath = $file->getRealPath();
                    $lastModified = File::lastModified($realPath);

                   // $lastModified = Carbon::parse($lastModified)->format("Y-m-d");
                   // $deletable_date = Carbon::parse($lastModified)->subDays($deletable)->format("Y-m-d");
                    // echo ("path= $path; lastModified = $lastModified ; deletableDate = $deletable_date ; deletable = $deletable \n");

                    /*si le fichier a déja fait plus de*/
                   // if ($deletable_date > $lastModified){
                   //     File::delete($realPath);
                   // }
                }
            }
        }
        return true;
    }
}

if (!function_exists('callApi')) {

    /**
     * Create API query and execute a GET/POST request
     * @param string $httpMethod GET/POST
     * @param string $endpoint
     * @param array $options
     * @return mixed
     * @throws GuzzleException|Exception
     */
     function callApi(string $httpMethod = "post", string $endpoint = "", array $options = []): mixed
     {

            $clientOptions = array_merge(['verify' => app()->isProduction()],$options['clientOptions'] ?? []);
            unset($options['clientOptions']);
            $client = new Client($clientOptions);
            try {
                $response = $client->request(strtoupper($httpMethod),$endpoint,$options);
                return json_decode($response->getBody()->getContents(),true);
            }catch (\Exception $exception){
                write_log("call-api",$exception,"error",$endpoint);
                throw $exception;
            }
    }
}

if (!function_exists('activeGuard')) {

    /**retourne la guarde active
     * @return string
     */
    function activeGuard(): string
    {
        $guards = new Collection(array_keys(config('auth.guards')));

        return $guards->first(fn(string $guard) => auth($guard)->check())
                       ?? request()->header('x-guard-name')
                       ?? "web";
    }
}

if (!function_exists('currentOrganization')) {

    /** Retourne l'organisation active dans la requete
     * @return BcOrganization|null
     */
    function currentOrganization(): ?BcOrganization
    {
        if ($organizationId = request()->header('x-organization-id')){
            return BcOrganization::find($organizationId);
        }
       return null;
    }
}

if (!function_exists("get_months")){
    /**
     * Get array of month list.
     *
     * @return array
     */
    function get_months(): array
    {
        return [
            '01' => __('Janvier'),
            '02' => __('Février'),
            '03' => __('Mars'),
            '04' => __('Avril'),
            '05' => __('Mai'),
            '06' => __('Juin'),
            '07' => __('Juillet'),
            '08' => __('Août'),
            '09' => __('Septembre'),
            '10' => __('Octobre'),
            '11' => __('Novembre'),
            '12' => __('Decembre'),
        ];
    }
}
if (! function_exists('user_location')) {
    /** retourne les données de localisation de l'user
     * @return  array
     * @throws Exception
     */
    function user_location(): array
    {
        //$ip = (env('APP_ENV') == "local") ? '154.72.168.247' : request()->ip();
//        if ($location = Location::get()) {
//           $location = $location->toArray();
//        }

        return [];
    }
}
if (!function_exists("get_week_numbers")){
    /** Get array of month list.
     * @param string $year
     * @return array
     */
    function get_week_numbers(string $year): array
    {
        $lastWeekOfTheYear =  Carbon::parse($year.'-01-01')->weeksInYear();
        return range(0, $lastWeekOfTheYear);
    }
}

if (!function_exists("format_size_units")){
    /**@param  int  $bytes  File size.
     * @return string Converted file size with unit.
     */
    function format_size_units(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2).' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes.' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes.' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }
}


if(!function_exists("booleanVal")){
    /**
     * Retourne la valeur booléene
     * @param int|string $value
     * @return boolean
     */
    function booleanVal(int|string $value): bool
    {
        return filter_var($value ?? true,FILTER_VALIDATE_BOOLEAN);
    }
}

if(!function_exists("general_error")){

    /**
     * @param $exception
     * @return mixed
     */
    function general_error($exception = null): mixed
    {
        $message = __("Une erreur imprévue est survenue lors de l'opération");
        $exceptions = [
          1
        ];

        if (!blank($exception) and (in_array(get_class($exception),$exceptions) or app()->isLocal())){
            $message = $exception->getMessage();
        }
        return $message;
    }
}

if(!function_exists("action_message")){
    function action_message($action = "",$is_success = true){
        $title = __("Opération");
        if ($action == "create"){
            $title = __("Enregistrement");
        }
        if ($action == "update"){
            $title = __("Modification");
        }elseif ($action == "delete"){
            $title = __("Suppression");
        }
        elseif ($action == "activate"){
            $title = (booleanVal(request()->get("is_active") ?? false))
                    ? __("Activation")
                    : __("Désactivation");
        }

        return ($is_success) ? __(":title Réussie.",['title' => $title]) : __("Echec :title",['title' => $title]);
    }
}

if(!function_exists("newReference")){

}

if(!function_exists("newId")){

    /**
     * Génère un nouvel identifiant unique pour un modèle donné
     * @param string $model Le modèle pour lequel on veut générer un ID
     * @param array|null $options Options supplémentaires
     * @return string
     * @throws BcNewIdCannotGeneratedException
     */
    function newId(string $model = "", ?array $options = []): string
    {
        $errorMsg = __("Le système n'a pas pu octroyer un nouvel identifiant.");

        // Vérifications initiales
        if (empty($model) || !class_exists($model)) {
            throw new BcNewIdCannotGeneratedException("$errorMsg [Raison] : " . __("Le modèle spécifié est invalide ou introuvable."));
        }

        $instance = new $model;

        if (!($instance instanceof Model)) {
            throw new BcNewIdCannotGeneratedException("$errorMsg [Raison] : " . __("Le modèle fourni n'est pas une instance de [Illuminate\Database\Eloquent\Model]"));
        }

        $keyName = $options['keyName'] ?? $instance->getKeyName();

        if (!isset($instance->$keyName)) {
            throw new BcNewIdCannotGeneratedException("$errorMsg [Raison] : " . __("Le champ '$keyName' n'existe pas dans le modèle $model"));
        }

        // Définition des paramètres
        $prefix = $options['prefix'] ?? date('my');
        $suffix = $options['suffixe'] ?? "";
        $separator = $options['separator'] ?? "";
        $maxAttempts = $options['maxAttempts'] ?? 4;

        $charLengthNextId = $options['charLengthNextId'] ?? 0; // La longueur du numéro généré

        $countBy = $options['countBy'] ?? [
                                            'column' => 'created_at',
                                            'value' => [
                                                Carbon::now()->startOfMonth(),
                                                Carbon::now()->endOfMonth()
                                            ]
                                        ];

        // Initialisation de la requête
        $query = $model::withoutGlobalScopes();

        if (isset($countBy['column'], $countBy['value'])) {
            if (is_array($countBy['value'])) {
                $query->whereBetween($countBy['column'], $countBy['value']);
            } else {
                $query->where($countBy['column'], $countBy['value']);
            }
        }

        // Génération d'un identifiant unique avec retry
        $attempts = 0;
        do {
            $attempts++;

            $nextId = $query->count() + $attempts; // Ajout du retry dans l'incrémentation

            $formattedId = str_pad($nextId, $charLengthNextId, '0', STR_PAD_LEFT);

            $newId = strtoupper("{$prefix}{$separator}{$formattedId}{$separator}{$suffix}");

            // Vérification d'unicité
            if (!$model::where($keyName, $newId)->exists()) {
                return $newId;
            }
        } 
        while ($attempts < $maxAttempts);

        throw new BcNewIdCannotGeneratedException("$errorMsg [Échec après $maxAttempts tentatives]");
    }
}


if(!function_exists("format_date")){
    /**
     * Format l'affichage d'une date
     * @param Carbon|string $date
     * @param string $format
     * @return mixed
     */
    function format_date(Carbon|string $date, string $format = "d-m-Y"): mixed
    {
        return Carbon::parse($date)->format($format);
    }
}

if(!function_exists("lifetime")){
    /**
     * Format l'affichage d'une date
     * @param Carbon|string $date
     * @return string
     */
    function lifetime(Carbon|string $date): string
    {
        return Carbon::parse($date)->diffForHumans();
    }
}

if(!function_exists("get_gravatar")){

    /**
     * @param $email
     * @param int $s
     * @param string $d
     * @param string $r
     * @param bool $img
     * @param array $atts
     * @return string
     */
    function get_gravatar($email = null, int $s = 80, string $d = 'mp', string $r = 'g', bool $img = false, array $atts =[]): string{
        $url = 'https://www.gravatar.com/avatar/';
        $email ??= fake()->email;
        $url .= md5(strtolower(trim($email)));
        $url .= "?s={$s}&d={$d}&r={$r}";

        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        return $url;
    }
}



if (! function_exists('preset')) {
    /**
     * retourne un preset
     * @param $file
     * @return  array
     */
    function preset($file): array
    {
        return ($file) ? config("presets.$file") : [];
    }
}

if (! function_exists('manager')) {

    /** Retourne le manager lié au un compte user
     * @param BcUser|null $user
     * @return BcUser|null
     */
    function manager(BcUser $user = null): ?BcUser
    {
        $user ??= auth((new BcUser)->guardName())?->user();
        return $user?->manager;
    }
}
