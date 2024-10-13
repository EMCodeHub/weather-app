<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;
use App\Models\Request as WeatherRequest; // Alias para evitar conflicto con Illuminate\Http\Request
use App\Services\Adapters\WeatherAdapterFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Asegúrate de importar esta clase
use Illuminate\Support\Facades\Cache; // Importa la fachada de Cache

class WeatherController extends Controller
{
    public function show(Request $request)
    {
        // Verificar si el formulario ha sido enviado
        if (!$request->has('lat') || !$request->has('lon')) {
            // Si no hay latitud ni longitud en la solicitud, solo mostrar el formulario
            return view('weather.show');
        }

        // Obtener los valores enviados por el usuario
        $lat = $request->input('lat');
        $lon = $request->input('lon');

        // Crear una clave única para la caché usando latitud y longitud
        $cacheKey = "weather_data_{$lat}_{$lon}";

        // Intentar obtener datos del caché
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            // Si hay datos en caché, usarlos
            return view('weather.show', [
                'averageTemperature' => $cachedData['averageTemperature'],
                'averageWindSpeed' => $cachedData['averageWindSpeed'],
                'apiData' => $cachedData['apiData']
            ]);
        }

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            // Guardar la solicitud en la tabla `requests`
            $weatherRequest = WeatherRequest::create([
                'latitude' => $lat,
                'longitude' => $lon
            ]);

            // Lista de fuentes de datos
            $sources = ['OpenMeteo', 'WeatherAPI']; // Asegúrate de incluir BrightSky aquí
            $temperatureTotal = 0;
            $windSpeedTotal = 0;
            $validSources = 0;
            $apiData = [];

            foreach ($sources as $source) {
                $adapter = WeatherAdapterFactory::create($source);
                $temperature = $adapter->getTemperature($lat, $lon);
                $windSpeed = $adapter->getWindSpeed($lat, $lon);
                $location = $adapter->getLocation($lat, $lon);
                $url = $adapter->getRequestUrl($lat, $lon); // Obtener la URL de la API

                // Almacenar los datos de la API, incluyendo la ubicación y la URL
                if ($temperature !== null && $windSpeed !== null) {
                    $apiData[$source] = [
                        'temperature' => $temperature,
                        'windSpeed' => $windSpeed,
                        'location' => $location,
                        'url' => $url // Añadir la URL aquí
                    ];

                    $temperatureTotal += $temperature;
                    $windSpeedTotal += $windSpeed;
                    $validSources++;

                    // Guardar los datos en la tabla `weather_data`
                    WeatherData::create([
                        'request_id' => $weatherRequest->id, // Relación con la solicitud
                        'source' => $source,
                        'temperature' => $temperature,
                        'wind_speed' => $windSpeed,
                        'latitude' => $lat,
                        'longitude' => $lon,
                        'location' => $location
                    ]);
                }
            }

            // Comprobar si no se obtuvieron datos válidos de ninguna fuente
            if ($validSources === 0) {
                return redirect()->back()->with('error', 'There was a problem fetching the data, maybe the API did not find the location. Please try with another latitude and longitude.');
            }

            // Calcular los promedios
            $averageTemperature = $temperatureTotal / $validSources;
            $averageWindSpeed = $windSpeedTotal / $validSources;

            // Almacenar los datos en caché por un tiempo definido (por ejemplo, 60 minutos)
            Cache::put($cacheKey, [
                'averageTemperature' => $averageTemperature,
                'averageWindSpeed' => $averageWindSpeed,
                'apiData' => $apiData
            ], 60); // 60 minutos

            // Confirmar la transacción
            DB::commit();

            // Pasar los datos a la vista
            return view('weather.show', [
                'averageTemperature' => $averageTemperature,
                'averageWindSpeed' => $averageWindSpeed,
                'apiData' => $apiData
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            // Manejar el error (puedes lanzar una excepción o mostrar un mensaje de error)
            return redirect()->back()->with('error', 'There was a problem fetching the data, maybe the API did not find the location. Please try with another latitude and longitude.');
        }
    }
}
