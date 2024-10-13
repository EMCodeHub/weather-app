<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\WeatherController;






Route::get('/', [WeatherController::class, 'show'])->name('weather.show');
Route::get('/weather/data', [WeatherController::class, 'index']); // Ruta para obtener todos los datos
Route::get('/weather/average', [WeatherController::class, 'getAverage']); // Ruta para obtener el promedio






