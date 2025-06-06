<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;

interface BillableItem extends Orderable,Invoiceable
{

    public function getItemId(): string|int;

    public function getSku(): string;

    public function getName(): string;

    public function getNote(): ?string;

    public function getProductId(): string;

}