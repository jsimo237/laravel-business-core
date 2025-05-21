<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Kirago\BusinessCore\Modules\SecurityManagement\Events\OtpCodeGenerated;
use Kirago\BusinessCore\Modules\SecurityManagement\Listeners\SendOtpCodeMail;

class BcEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OtpCodeGenerated::class => [
            SendOtpCodeMail::class,
        ],
    ];
}