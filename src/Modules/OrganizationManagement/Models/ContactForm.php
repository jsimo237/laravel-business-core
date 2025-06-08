<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;

/**
 * @property string fullname
 */
class ContactForm extends BaseModel {

    protected $table = "organization__mgt_contacts_form";


    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
