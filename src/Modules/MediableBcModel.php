<?php

namespace Kirago\BusinessCore\Modules;

use Kirago\BusinessCore\Models\Str;
use Kirago\BusinessCore\Modules\CoresManagement\Traits\Mediable;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class MediableBcModel extends BaseBcModel implements SpatieHasMedia {

    use InteractsWithMedia,Mediable;


    public function registerMediaCollections(): void{
        $this->addMediaCollection(Str::plural($this->getMorphClass()))
                ->singleFile() // ne doit contenir qu'un seul fichier sur la collection ( utilisateur n'a qu'un seul avatar )
                ->useFallbackUrl(get_gravatar($this->email ?? fake()->email)) // retouné lorsque getUrl = null
            //->useFallbackUrl(url("img/avatar.png")) // retouné lorsque getUrl = null
        ;

    }
}
