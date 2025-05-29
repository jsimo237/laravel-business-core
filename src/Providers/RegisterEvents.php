<?php

namespace Kirago\BusinessCore\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Kirago\BusinessCore\Helpers\EventProviderHelper;

trait RegisterEvents
{



    protected function registerListeners(): void
    {
        $listenerPaths = EventProviderHelper::discoverListenerPathsFromModules();

        if (method_exists(EventServiceProvider::class, 'addEventDiscoveryPaths')) {
            // Laravel 11+
            EventServiceProvider::addEventDiscoveryPaths($listenerPaths);
        } else {
            // Laravel 10 fallback – manually register listeners
            foreach ($listenerPaths as $path) {
                foreach (glob($path . DIRECTORY_SEPARATOR . '*.php') as $listenerFile) {
                    $listenerClass = EventProviderHelper::getFullyQualifiedClassName($listenerFile);
                    $eventClass = EventProviderHelper::getEventHandledByListener($listenerFile);

                    if (class_exists($listenerClass) && $eventClass && class_exists($eventClass)) {
                        Event::listen($eventClass, $listenerClass);
                    }
                }
            }
        }

//        $eventsMap = $this->loadCachedEventMap();
//
//        if (!$eventsMap) {
//            $eventsMap = $this->buildEventMapDynamically();
//        }
//
//
//        foreach ($eventsMap as $event => $listeners) {
//            foreach ($listeners as $listener) {
//                Event::listen($event, $listener);
//            }
//        }
    }

    protected function loadCachedEventMap(): ?array
    {
        $path = storage_path('framework/cache/business-core/events.php');
        if (file_exists($path)) {
            return include $path;
        }

        return null;
    }

    protected function buildEventMapDynamically(): array
    {
        $listenerPaths = EventProviderHelper::discoverListenerPathsFromModules();
        $eventsMap = [];

        foreach ($listenerPaths as $path) {
            $phpFiles = File::allFiles($path);

            foreach ($phpFiles as $file) {
                $class = EventProviderHelper::getFullyQualifiedClassName($file->getPathname());

                if ($class && method_exists($class, 'handle')) {
                    $event = EventProviderHelper::getEventHandledByListener($class);
                    if ($event) {
                        $eventsMap[$event][] = $class;
                    }
                }
            }
        }

        return $eventsMap;
    }


}