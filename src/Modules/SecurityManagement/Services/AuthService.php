<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Services;

use Illuminate\Database\Eloquent\Builder;
use Kirago\BusinessCore\Modules\SecurityManagement\Contracts\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class AuthService
{


    public function __construct(protected string $type)
    {
        $guards = array_keys(static::getAllAuthenticables());

        if (!in_array($this->type, $guards)) {
            throw new \InvalidArgumentException("Invalid guard type: {$this->type}");
        }
    }


    protected function getModelInstance(): AuthenticatableModelContract{
        $modelClass = static::getAuthenticable($this->type);
        return (new $modelClass);
    }

    public static function getAllAuthenticables(){
        return config("business-core.authenticables");
    }

    public static function getAuthenticable(string $guardName){
        return config("business-core.authenticables.$guardName");
    }

    /**
     * Recherche un utilisateur à partir des identifiants définis par son modèle.
     */
    public function findUserByIdentifier(string $identifier): ?BcUser
    {
        /**
         * @var AuthenticatableModelContract
         */
        $model = $this->findModelByIdentifier($identifier);

        return $model?->getUser();
    }

    public function findModelByIdentifier(string $identifier): ?AuthenticatableModelContract
    {
        /**
         * @var Builder
         */
        $model = $this->getModelInstance()->newQuery();

        /**
         * @var array
         */
        $identifiers = $model->getAuthIdentifiersFields();

        return $model->whereMultiple($identifiers,$identifier);

    }


    /**
     * Tente d'authentifier un utilisateur.
     * @param string $identifier
     * @param string $password
     * @param array|null $options
     * @return array
     */
    public function authenticate(string $identifier, string $password, ?array $options = []): array
    {

        $checkHash = $options['checkHash'] ?? true;
        $data      = $options['data'] ?? [];

        //Appareil utilisé pour s'autentifier
        $userAgent = $data["agent"] ?? request()->userAgent();

        /**
         * @var AuthenticatableModelContract
         */
        $model = $this->findModelByIdentifier($identifier);

        $passwordField = $model->getAuthPasswordField();

        /**
         * @var BcUser
         */
        $user = $model->getUser();

        //si l'user n'exite pas
        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => ["Incorrect Identifier."],
            ]);
        }

        $wrongPassword = ($checkHash)
                        ? !Hash::check($password, $user->{$passwordField})
                        : ($user->{$passwordField} !== $password );

        if ($wrongPassword){
            throw ValidationException::withMessages([
                'password' => ["Incorrect Password."],
            ]);
        }

        $expireIn        = config("sanctum.expiration");

        $expiredAt       = Carbon::now()->addMinutes($expireIn);

        //Si le compte est actif
        if ($user->isActive()){
            //supprime toutes les connexions avec cet appareil
            //$user->tokens()->where('name',$userAgent)->delete();
            //$currentAccessToken = $user->currentAccessToken()->where('agent',$userAgent)->first();

            $abilities       = $user?->privileges ?? $user?->permissions?->pluck("name")->toArray() ?? ["*"];

            $newAccessToken  = $user->createToken($userAgent,$abilities,$expiredAt);

            $token           = $newAccessToken->plainTextToken;

            $accessToken     = explode('|', $token)[1];

            return [
                $model,
                $accessToken ,
                $expiredAt
            ] ;
        }

        throw ValidationException::withMessages([
            'identifier' => ["Inactive user account."],
        ]);
    }
}