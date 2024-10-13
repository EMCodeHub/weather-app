<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;
use App\Console\Commands\WeatherProducer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class WeatherProducerTest extends TestCase
{
    use RefreshDatabase;

    public function test_produce_weather_data()
    {
        $this->withoutMockingConsoleOutput();

        // Simular la producción de datos
        Log::shouldReceive('info')->once()->with('Weather data produced successfully.');

        $this->artisan(WeatherProducer::class)
            ->expectsOutput('Weather data produced successfully.')
            ->assertExitCode(0);
    }
}
