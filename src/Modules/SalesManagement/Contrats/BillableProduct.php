<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

interface BillableProduct
{

    public function getItemId(): string|int;

    public function getSku(): string;

    public function getName(): string;

    public function getNote(): ?string;

    public function getProductId(): string;

}