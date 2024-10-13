<?php

namespace App\Services\Adapters;

interface WeatherAdapterInterface
{
    public function getTemperature(float $lat, float $lon): ?float;
    public function getWindSpeed(float $lat, float $lon): ?float;
    public function getLocation(float $lat, float $lon): ?string;
    public function getRequestUrl(float $lat, float $lon): string; // Nuevo método
}
