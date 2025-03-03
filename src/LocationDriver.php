<?php

namespace Kirago\BusinessCore;


use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Position;
use Stevebauman\Location\Request;
use Stevebauman\Location\Drivers\Driver;

class LocationDriver extends Driver {

    protected function process(Request $request): Fluent{
        $response = Http::get("https://driver-url.com", ['ip' => $request->getIp()]);

        return new Fluent($response->json());
    }

    protected function hydrate(Position $position, Fluent $location): Position{
        $position->countryCode = $location->country_code;

        return $position;
    }

}