<?php

namespace Kirago\BusinessCore\Support\Constants;

enum BcReasonCode : string
{

    case ORGANIZATION_NOT_FOUND            = "ORGANIZATION_NOT_FOUND";
    case ORGANIZATION_INACTIVE             = "ORGANIZATION_INACTIVE";
    case REQUIRED_X_ORGANIZATION_ID_HEADER = "REQUIRED_X_ORGANIZATION_ID_HEADER";
    case UNABLE_TO_GET_DRIVER              = "UNABLE_TO_GET_DRIVER";
    case APPLICATION_ERROR                 = "APPLICATION_ERROR";
    case USER_NOT_FOUND                   = "USER_NOT_FOUND";

    case REQUIRED_X_AUTH_GUARD_HEADER     = "REQUIRED_X_AUTH_GUARD_HEADER";
    case INVALID_AUTH_GUARD               = "INVALID_AUTH_GUARD";


}