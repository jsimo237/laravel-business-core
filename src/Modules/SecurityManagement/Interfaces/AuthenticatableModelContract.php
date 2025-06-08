<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Interfaces;

use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property User user
 */
interface AuthenticatableModelContract
{
    /**
     * Retourne la liste des champs utilisables pour l'authentification
     */
    public static function getAuthIdentifiersFields(): array;

    public static function getAuthPasswordField(): ?string;

    public function getUser(): ?User;
    public function user(): ?MorphOne;

    /**
     * Retourne le nom de la garde utilisée par ce modèle
     */
    public function guardName(): string;
}