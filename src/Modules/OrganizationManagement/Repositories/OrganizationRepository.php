<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Repositories;

use Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization;

class OrganizationRepository {

    public function __construct(protected int|string|Organization $organization)
    {
    }

    protected static int|string $organizationId;

    public static function setOrganization(int|string $organizationId)
    {
        self::$organizationId= $organizationId;
    }

    public function getOrganization() : int|string
    {

        if ( $this->organization instanceof Organization){
            return $this->organization;
        }

        return Organization::find($this->organization);
    }


}