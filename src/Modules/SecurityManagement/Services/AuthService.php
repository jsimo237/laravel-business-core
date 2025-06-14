<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Services;

use Illuminate\Database\Eloquent\Builder;
use Kirago\BusinessCore\Modules\SecurityManagement\Interfaces\AuthenticatableModelContract;
use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class AuthService
{


    public function __construct(protected string $guardName)
    {
        $guards = array_keys(static::getAllAuthenticables());

        if (!in_array($this->guardName, $guards)) {
            throw new \InvalidArgumentException("Invalid guard type: {$this->guardName}");
        }
    }


    protected function getModelInstance() : AuthenticatableModelContract{
        $modelClass = static::getAuthenticable($this->guardName);
        return (new $modelClass);
    }

    public function getModelClass(): string{
        return static::getAuthenticable($this->guardName);
    }

    public static function getAllAuthenticables(): array
    {
        return config("business-core.authenticables");
    }

    public static function getAuthenticable(string $guardName){
        return self::getAllAuthenticables()[$guardName] ?? null;
    }

    /**
     * Recherche un utilisateur à partir des identifiants définis par son modèle.
     */
    public function findUserByIdentifier(string $identifier): ?User
    {
        /**
         * @var AuthenticatableModelContract
         */
        $model = $this->findModelByIdentifier($identifier);

        return $model?->getUser();
    }

    public function findModelByIdentifier(string $identifier) : ?AuthenticatableModelContract
    {
        /**
         * @var Builder
         */
        $model = $this->getModelInstance()->newQuery();

        /**
         * @var array
         */
        $identifiers = $this->getModelClass()::getAuthIdentifiersFields();

        return $model->whereMultiple($identifiers,$identifier)
                    ->first();

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

        $passwordField = $this->getModelClass()::getAuthPasswordField();

        /**
         * @var User
         */
        $user = $model?->getUser();

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

         //   $refreshToken = $user->createToken('refresh-token', ['refresh'])->plainTextToken;
            $refreshToken = $user->createToken('refresh-token', ['refresh'], now()->addDays(30));


            $token           = $newAccessToken->plainTextToken;

            $accessToken     = explode('|', $token)[1];
            $refreshToken     = explode('|', $refreshToken->plainTextToken)[1];

            return [
                $model,
                $accessToken ,
                $refreshToken,
                $expiredAt
            ] ;
        }

        throw ValidationException::withMessages([
            'identifier' => ["Inactive user account."],
        ]);
    }
}