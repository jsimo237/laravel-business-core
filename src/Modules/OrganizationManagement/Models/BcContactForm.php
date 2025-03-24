<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;

/**
 * @property string fullname
 */
class BcContactForm extends BaseBcModel {

    protected $table = "organization__mgt_contacts_form";


    public function getObjectName(): string
    {
        return $this->fullname;
    }
}
