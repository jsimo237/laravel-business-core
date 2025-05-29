<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Support\Facades\Blade;
use Kirago\BusinessCore\Helpers\ViewComponentProviderHelper;
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

        $components = ViewComponentProviderHelper::getValidBladeComponents();

        $prefix = 'business-core';

        // Laravel 10+
        if (method_exists($this, 'loadViewComponentsAs')) {
            $this->loadViewComponentsAs('business-core', $components);
        } else {
            // fallback éventuel si tu dois supporter une version Laravel < 10 (rare)
            foreach ($components as $component) {
                \Illuminate\Support\Facades\Blade::component($component, null, $prefix);
            }
        }
    }
}