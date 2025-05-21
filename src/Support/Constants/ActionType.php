<?php


namespace Kirago\BusinessCore\Support\Constants;


enum ActionType : string{

    case CREATE = "create";
    case UPDATE = "update";
    case DELETE = "delete";
    case VIEW   = "view";
    case IMPORT = "import";
}
