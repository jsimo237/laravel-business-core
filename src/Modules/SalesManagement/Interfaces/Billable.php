<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Interfaces;


interface Billable
{
    public function produceBillPDF() : array;
}