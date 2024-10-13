<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'latitude',
        'longitude',
    ];

    public function weatherData()
    {
        return $this->hasMany(WeatherData::class);
    }
}
