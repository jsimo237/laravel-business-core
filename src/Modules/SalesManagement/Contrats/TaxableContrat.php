<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

interface TaxableContrat
{

    /** @return array<TaxableItemContrat> */
    public function getTaxableItems(): array;
}