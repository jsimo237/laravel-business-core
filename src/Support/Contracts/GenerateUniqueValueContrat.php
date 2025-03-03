<?php

namespace Kirago\BusinessCore\Support\Contracts;

interface GenerateUniqueValueContrat
{
    public function generateUniqueValue(string $field = "code") : void ;
}