<?php

namespace Kirago\BusinessCore\Support\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface AuthorAssignable
{
    public function createdBy(): ?BelongsTo;
    public function updatedBy(): ?BelongsTo;
}
