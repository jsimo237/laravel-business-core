<?php

namespace Kirago\BusinessCore\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Kirago\BusinessCore\Helpers\EventProviderHelper;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Collection;


class EventServiceProvider extends ServiceProvider
{


    public function boot(){

        $listenerPaths = EventProviderHelper::discoverListenerPathsFromModules();

        // Laravel 10+ fallback – manually register listeners

        collect($listenerPaths)
            /**
             * remplace la boucle interne en extrayant tous les fichiers *.php de tous les dossiers.
             */
            ->flatMap(fn($path) => glob($path . DIRECTORY_SEPARATOR . '*.php') ?: [])
            ->each(function ($listenerFile) {
                $listenerClass = EventProviderHelper::getFullyQualifiedClassName($listenerFile);
                $eventClass = EventProviderHelper::getEventHandledByListener($listenerFile);

                if (class_exists($listenerClass) && $eventClass && class_exists($eventClass)) {
                    Event::listen($eventClass, $listenerClass);
                }
            });


    }


}