<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;


interface Billable
{
    public function produceBillPDF() : array;
}