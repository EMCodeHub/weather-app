<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;
use App\Console\Commands\WeatherConsumer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class WeatherConsumerTest extends TestCase
{
    use RefreshDatabase;

    public function test_consume_weather_data()
    {
        // Simular la recepción de un mensaje de Kafka
        Log::shouldReceive('info')->once()->with("Received weather data: Temperature: 20.5, Wind Speed: 5.0 at Copenhagen");

        $this->artisan(WeatherConsumer::class)
            ->expectsOutput('Received weather data: Temperature: 20.5, Wind Speed: 5.0 at Copenhagen')
            ->assertExitCode(0);
    }
}
