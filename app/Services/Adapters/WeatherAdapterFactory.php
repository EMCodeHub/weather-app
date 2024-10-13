<?php
// app/Services/Adapters/WeatherAdapterFactory.php

namespace App\Services\Adapters;

class WeatherAdapterFactory
{
    public static function create(string $source): WeatherAdapterInterface
    {
        return match ($source) {
            'BrightSky' => new BrightSkyAdapter(),
            'OpenMeteo' => new OpenMeteoAdapter(),
            'WeatherAPI' => new WeatherAPIAdapter(),
            default => throw new \InvalidArgumentException("Unknown API source: {$source}"),
        };
    }
}
