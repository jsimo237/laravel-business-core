<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseBcModel;

class Contact extends BaseBcModel {

    protected $table = "organization__mgt__contacts_forms";





    public function getObjectName(): string
    {
        return $this->getKeyName();
    }
}
