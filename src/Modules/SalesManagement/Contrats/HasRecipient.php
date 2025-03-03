<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property MorphTo recipient
 */
interface HasRecipient
{

    public function recipient() : MorphTo;
}