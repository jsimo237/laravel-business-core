<?php

namespace Kirago\BusinessCore\Support\Contracts;


interface EventNotifiableContract
{

    /**
     * Nom de l'objet qui sera utilisé pour les evènements (hooks)
     * @return string
     */
    public function getObjectName(): string;
}