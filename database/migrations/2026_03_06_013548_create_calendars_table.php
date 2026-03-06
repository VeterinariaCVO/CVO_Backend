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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();

            // Día concreto del calendario
            $table->date('date');

            // Estado del día
            $table->boolean('is_open')->default(true);   // abierto/cerrado
            $table->boolean('is_special')->default(false); // true si tiene horario especial

            // Horario del día (si es null, podrías usar el de calendar_settings)
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
