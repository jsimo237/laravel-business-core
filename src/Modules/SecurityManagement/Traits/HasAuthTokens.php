<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Traits;

use DateTimeInterface;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

trait HasAuthTokens {

    use HasApiTokens;


    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array|null $abilities
     * @param DateTimeInterface|null $expiredAt
     * @return NewAccessToken
     */
    public function createToken(string $name, ?array $abilities = ['*'], ?DateTimeInterface $expiredAt = null) : NewAccessToken
    {

        $token = $this->tokens()
                      ->create([
                        'name' => $name,
                        'token' => hash('sha256', $plainTextToken = Str::random(40)),
                        'abilities' => $abilities,
                        'expires_at' => $expiredAt,
                     ]);

        return new NewAccessToken(
                    $token,
                    $token->getKey().'|'.$plainTextToken
                );
    }


}
