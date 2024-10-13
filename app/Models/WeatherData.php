<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $table = 'weather_data';

    protected $fillable = [
        'source',
        'temperature',
        'wind_speed',
        'latitude',
        'longitude',
        'location',
        'request_id' // Relación con la solicitud
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
