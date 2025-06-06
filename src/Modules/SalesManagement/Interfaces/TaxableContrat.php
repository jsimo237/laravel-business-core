<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

interface TaxableContrat
{

    /** @return array<TaxableItemContrat> */
    public function getTaxableItems(): array;
}