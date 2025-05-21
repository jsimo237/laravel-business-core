<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Contracts;

use Kirago\BusinessCore\Modules\SecurityManagement\Models\BcUser;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property BcUser user
 */
interface AuthenticatableModelContract
{
    /**
     * Retourne la liste des champs utilisables pour l'authentification
     */
    public static function getAuthIdentifiersFields(): array;

    public static function getAuthPasswordField(): ?string;

    public function getUser(): ?BcUser;
    public function user(): ?MorphOne;

    /**
     * Retourne le nom de la garde utilisée par ce modèle
     */
    public function guardName(): string;
}