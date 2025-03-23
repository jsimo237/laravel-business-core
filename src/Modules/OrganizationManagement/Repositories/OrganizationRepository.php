<?php

namespace Kirago\BusinessCore\Modules\OrganizationManagement\Repositories;

use Kirago\BusinessCore\Modules\OrganizationManagement\Models\BcOrganization;

class OrganizationRepository {

    public function __construct(protected int|string|BcOrganization $organization)
    {
    }

    protected static int|string $organizationId;

    public static function setOrganization(int|string $organizationId)
    {
        self::$organizationId= $organizationId;
    }

    public function getOrganization() : int|string
    {

        if ( $this->organization instanceof BcOrganization){
            return $this->organization;
        }

        return BcOrganization::find($this->organization);
    }


}