<?php

namespace App\Services\Adapters;

use GuzzleHttp\Client;

class WeatherAPIAdapter implements WeatherAdapterInterface
{
    private $client;
    private $baseUrl = 'https://api.weatherapi.com/v1/current.json';
    private $apiKey;

    public function __construct()
    {
        // Crear el cliente Guzzle con la opción 'verify' desactivada
        $this->client = new Client(['verify' => false]);
        $this->apiKey = config('services.weatherapi.key');
    }

    public function getTemperature(float $lat, float $lon): ?float
    {
        // Deshabilitar verificación SSL en la solicitud
        $response = $this->client->get("{$this->baseUrl}?key={$this->apiKey}&q={$lat},{$lon}", [
            'verify' => false,
        ]);
        $data = json_decode($response->getBody(), true);
        return $data['current']['temp_c'] ?? null;
    }

    public function getWindSpeed(float $lat, float $lon): ?float
    {
        // Deshabilitar verificación SSL en la solicitud
        $response = $this->client->get("{$this->baseUrl}?key={$this->apiKey}&q={$lat},{$lon}", [
            'verify' => false,
        ]);
        $data = json_decode($response->getBody(), true);
        return $data['current']['wind_kph'] ?? null;
    }

    public function getLocation(float $lat, float $lon): ?string
    {
        // Deshabilitar verificación SSL en la solicitud
        $response = $this->client->get("{$this->baseUrl}?key={$this->apiKey}&q={$lat},{$lon}", [
            'verify' => false,
        ]);
        $data = json_decode($response->getBody(), true);
        return $data['location']['name'] ?? null;
    }

    public function getRequestUrl(float $lat, float $lon): string // Implementación del nuevo método
    {
        return "{$this->baseUrl}?key={$this->apiKey}&q={$lat},{$lon}";
    }
}
