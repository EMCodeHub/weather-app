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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue', 191)->index(); // Limitar a 191 caracteres
            $table->text('payload'); // Mantener como text
            $table->unsignedTinyInteger('attempts'); // Mantener
            $table->unsignedInteger('reserved_at')->nullable(); // Mantener
            $table->unsignedInteger('available_at'); // Mantener
            $table->unsignedInteger('created_at'); // Mantener
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id', 191)->primary(); // Limitar a 191 caracteres
            $table->string('name', 191); // Limitar a 191 caracteres
            $table->unsignedInteger('total_jobs'); // Cambiar a unsignedInteger para mayor claridad
            $table->unsignedInteger('pending_jobs'); // Cambiar a unsignedInteger
            $table->unsignedInteger('failed_jobs'); // Cambiar a unsignedInteger
            $table->text('failed_job_ids'); // Mantener como text
            $table->mediumText('options')->nullable(); // Mantener
            $table->unsignedInteger('cancelled_at')->nullable(); // Cambiar a unsignedInteger
            $table->unsignedInteger('created_at'); // Mantener
            $table->unsignedInteger('finished_at')->nullable(); // Cambiar a unsignedInteger
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 191)->unique(); // Limitar a 191 caracteres
            $table->text('connection'); // Mantener como text
            $table->text('queue'); // Mantener como text
            $table->text('payload'); // Mantener como text
            $table->longText('exception'); // Mantener como longText
            $table->timestamp('failed_at')->useCurrent(); // Mantener
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
