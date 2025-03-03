<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Models;

use Kirago\BusinessCore\Modules\BaseModel;

class Contact extends BaseModel {

    protected string $table = "organization__mgt__contacts_forms";





    public function getObjectName(): string
    {
        return $this->getKeyName();
    }
}
