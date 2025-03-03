<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;


// use Illuminate\Mail\Mailables\Attachment;

/**
 * @property string $billing_entity_type
 * @property string $billing_company_name
 * @property string $billing_firstname
 * @property string $billing_lastname
 */
interface BillableContrat
{

    public function produceBillPDF() : array;
}