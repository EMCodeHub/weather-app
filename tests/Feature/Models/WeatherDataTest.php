<?php

namespace Tests\Feature\Models;

use App\Models\Request;
use App\Models\WeatherData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_weather_data()
    {
        $weatherRequest = Request::create([
            'latitude' => 55.0,
            'longitude' => 13.0,
        ]);

        $data = [
            'source' => 'OpenMeteo',
            'temperature' => 20.5,
            'wind_speed' => 5.0,
            'latitude' => 55.0,
            'longitude' => 13.0,
            'location' => 'Copenhagen',
            'request_id' => $weatherRequest->id,
        ];

        $weatherData = WeatherData::create($data);

        $this->assertDatabaseHas('weather_data', $data);
        $this->assertEquals($data['temperature'], $weatherData->temperature);
        $this->assertEquals($data['wind_speed'], $weatherData->wind_speed);
    }
}
