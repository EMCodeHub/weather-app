<?php

namespace App\Services\Adapters;

use GuzzleHttp\Client;

class OpenMeteoAdapter implements WeatherAdapterInterface
{
    private $client;
    private $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getTemperature(float $lat, float $lon, $options = []): ?float
    {
        $response = $this->client->get("{$this->baseUrl}?latitude={$lat}&longitude={$lon}&current=temperature_2m,wind_speed_10m", array_merge($options, [
            'verify' => false, // Deshabilitar la verificación SSL aquí
        ]));
        $data = json_decode($response->getBody(), true);
        return $data['current']['temperature_2m'] ?? null;
    }

    public function getWindSpeed(float $lat, float $lon, $options = []): ?float
    {
        $response = $this->client->get("{$this->baseUrl}?latitude={$lat}&longitude={$lon}&current=temperature_2m,wind_speed_10m", array_merge($options, [
            'verify' => false, // Deshabilitar la verificación SSL aquí
        ]));
        $data = json_decode($response->getBody(), true);
        return $data['current']['wind_speed_10m'] ?? null;
    }

    public function getLocation(float $lat, float $lon): ?string
    {
        return "The API doesn't provide us with the city name of the location."; // Puede personalizarse si es necesario
    }

    public function getRequestUrl(float $lat, float $lon): string // Implementación del nuevo método
    {
        return "{$this->baseUrl}?latitude={$lat}&longitude={$lon}&current=temperature_2m,wind_speed_10m";
    }
}
