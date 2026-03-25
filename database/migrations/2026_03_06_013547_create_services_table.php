<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};


// database/migrations/xxxx_create_consultations_table.php




    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();

            // Anamnesis
            $table->date('illness_onset')->nullable();      // Inicio de enfermedad
            $table->string('drops')->nullable();            // Gotas
            $table->string('habitat')->nullable();          // Hábitat
            $table->text('vaccines')->nullable();           // Vacunas
            $table->text('previous_illnesses')->nullable(); // Enf. Anteriores
            $table->text('feeding')->nullable();            // Alimentación
            $table->text('previous_treatments')->nullable();// Trat. Anteriores

            // Constantes fisiológicas
            $table->decimal('temperature', 5, 2)->nullable();  // TEMP
            $table->integer('heart_rate')->nullable();          // FC/MIN
            $table->integer('respiratory_rate')->nullable();    // FR/MIN
            $table->string('capillary_refill')->nullable();     // Llenado Capilar
            $table->string('mucous_color')->nullable();         // Color Mucosas
            $table->string('body_condition')->nullable();       // EGG (condición corporal)
            $table->string('special_constants')->nullable();    // Especial

            // Diagnóstico
            $table->text('dx')->nullable();                     // DX
            $table->text('dx_presumptive')->nullable();         // DX Presuntivo
            $table->text('dx_differential')->nullable();        // DX Diferencial

            // Notas
            $table->text('recipe')->nullable();                 // Resma/Receta
            $table->text('observations')->nullable();           // Observaciones
            $table->text('notes')->nullable();                  // Notas

            // Alta
            $table->date('discharge_date')->nullable();
            $table->text('discharge_reason')->nullable();

            // Muerte
            $table->boolean('is_deceased')->default(false);
            $table->text('death_reason')->nullable();
            $table->dateTime('death_time')->nullable();

            // Presupuesto
            $table->decimal('total_budget', 10, 2)->nullable();
            $table->decimal('deposit', 10, 2)->default(0);

            $table->foreignId('attended_by')->constrained('users'); // Médico
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
}
