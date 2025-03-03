<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Contrats;

// use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


interface BaseOrderContract
{

    public function refreshOrder() : void;

    public function invoice() : BelongsTo;

    public function user() : BelongsTo;

    public function send() :void;

}