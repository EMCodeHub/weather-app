<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Request;
use App\Models\WeatherData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_weather_with_valid_lat_lon()
    {
        $requestData = Request::create([
            'latitude' => 55.0,
            'longitude' => 13.0,
        ]);

        WeatherData::create([
            'source' => 'OpenMeteo',
            'temperature' => 20.5,
            'wind_speed' => 5.0,
            'latitude' => 55.0,
            'longitude' => 13.0,
            'location' => 'Copenhagen',
            'request_id' => $requestData->id,
        ]);

        $response = $this->get('/weather?lat=55.0&lon=13.0');

        $response->assertStatus(200);
        $response->assertViewHas('averageTemperature', 20.5);
        $response->assertViewHas('averageWindSpeed', 5.0);
    }

    public function test_show_weather_without_lat_lon()
    {
        $response = $this->get('/weather');

        $response->assertStatus(200);
        $response->assertViewIs('weather.show');
    }
}
