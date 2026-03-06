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
        Schema::create('calendar_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('block_duration')->default(30); // minutos
            $table->time('start_time')->default('08:00:00');
            $table->time('end_time')->default('18:00:00');

            // Días laborales por defecto: lunes a viernes
            // Puedes leerlo como array con un accessor en el modelo
            $table->string('working_days')->default('mon,tue,wed,thu,fri');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_settings');
    }
};
