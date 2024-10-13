<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherDataTable extends Migration
{
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id(); // ID único
            $table->unsignedBigInteger('request_id'); // Campo para la relación con la tabla requests
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade'); // Clave foránea
            $table->string('source'); // De qué API proviene
            $table->float('temperature'); // Temperatura en °C
            $table->float('wind_speed'); // Velocidad del viento en km/h
            $table->float('latitude'); // Latitud
            $table->float('longitude'); // Longitud
            $table->string('location'); // Nombre de la ubicación
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_data');
    }
}
