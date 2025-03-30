<?php

namespace Kirago\BusinessCore\Support\Constants;

enum ReasonCode : string
{

    case ORGANIZATION_NOT_FOUND         = "ORGANIZATION_NOT_FOUND";
    case ORGANIZATION_INACTIVE          = "ORGANIZATION_INACTIVE";


    case REQUIRED_X_ORGANIZATION_ID_HEADER = "REQUIRED_X_ORGANIZATION_ID_HEADER";

    case UNABLE_TO_GET_DRIVER              = "UNABLE_TO_GET_DRIVER";


}