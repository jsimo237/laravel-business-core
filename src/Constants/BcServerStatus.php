<?php

namespace Kirago\BusinessCore\Constants;

enum BcServerStatus : int
{

    case  SUCCESS                              =    200;   // request success
    case  NOT_FOUND                            =    404;   // page/resource not found
    case  AUTH_REQUIRED                        =    401;   // authentification required
    case  ALREADY_AUTHENTICATE                 =    302;   // already  authenticate
    case  PERMISSION_DENIED                    =    403;   // permissions denied
    case  CSFR_TOKEN_MISMATCH                  =    419;   // CSFR token mismatch
    case  UNPROCESSABLE_ENTITY                 =    422;   // Unprocessable Entity
    case  APPLICATION_ERROR                    =    500;   // application Error exception
    case  APPLICATION_IN_MAINTENANCE           =    501;   // application in maintenance mode
    case  BAD_REQUEST_HEADER                   =    502;   //
    case  RESOURCE_DISABLED                    =    504;   // Ressource désactivé


}