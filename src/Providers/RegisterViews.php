<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Support\Facades\Blade;
use Kirago\BusinessCore\Helpers\ViewComponentProviderHelper;

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
            // fallback éventuel pour Laravel < 10 (rare)
            foreach ($components as $component) {
                Blade::component($component, null, $prefix);
            }
        }
    }
}