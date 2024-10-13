<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key', 191)->primary(); // Limitar a 191 caracteres
            $table->text('value'); // Mantener como text, suficiente para almacenamiento
            $table->integer('expiration'); // Mantener
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key', 191)->primary(); // Limitar a 191 caracteres
            $table->string('owner', 100); // Limitar a 100 caracteres
            $table->integer('expiration'); // Mantener
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
