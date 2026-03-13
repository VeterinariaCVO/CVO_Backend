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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species'); // Tipo (perro, gato, etc.)
            $table->string('breed')->nullable(); // Raza
            $table->string('color')->nullable();
            $table->string('special_marks')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('sex', ['male', 'female'])->default('male');
            $table->integer('age')->nullable();
            $table->string('photo_path')->nullable(); // Ruta de la foto
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
