<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Support\Facades\Blade;
use Kirago\BusinessCore\Modules\SecurityManagement\View\Components\OtpCodeRender;

trait RegisterViews
{
    /**
     * Pour Laravel 9/10 : Middleware registration classique.
     */
    public function bootWithViews(){

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'business-core');
    }

    public function bootWithViewsComponents(){

        Blade::component('x-otp-code-render', OtpCodeRender::class);
    }
}