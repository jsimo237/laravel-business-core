<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Contracts;

use Kirago\BusinessCore\Modules\SecurityManagement\Models\User;

interface AuthenticatableModelContract
{
    /**
     * Retourne la liste des champs utilisables pour l'authentification
     */
    public function getAuthIdentifiersFields(): array;

    public function getAuthPasswordField(): ?string;

    public function getUser(): ?User;

    /**
     * Retourne le nom de la garde utilisée par ce modèle
     */
    public function getGuardName(): string;
}