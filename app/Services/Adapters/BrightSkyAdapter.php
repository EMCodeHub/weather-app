<?php

namespace App\Services\Adapters;

use GuzzleHttp\Client;

class BrightSkyAdapter implements WeatherAdapterInterface // Implementando la interfaz
{
    protected $client;
    private $baseUrl = 'https://api.brightsky.dev/current_weather'; // Definimos la URL base

    public function __construct()
    {
        $this->client = new Client(['verify' => false]); // Desactiva la verificación SSL
    }

    public function getTemperature(float $lat, float $lon): ?float // Ajustado a la firma de la interfaz
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'lat' => $lat,
                'lon' => $lon,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['current_weather']['temperature'] ?? null; // Ajusta esto según tu API
    }

    public function getWindSpeed(float $lat, float $lon): ?float // Ajustado a la firma de la interfaz
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'lat' => $lat,
                'lon' => $lon,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['current_weather']['wind_speed'] ?? null; // Ajusta esto según tu API
    }

    public function getLocation(float $lat, float $lon): ?string // Ajustado a la firma de la interfaz
    {
        return "The API doesn't provide us with the city name of the location."; // Ajusta esto según tu lógica
    }

    public function getRequestUrl(float $lat, float $lon): string // Implementación del nuevo método
    {
        return "{$this->baseUrl}?lat={$lat}&lon={$lon}"; // Construir y devolver la URL de la solicitud
    }
}
