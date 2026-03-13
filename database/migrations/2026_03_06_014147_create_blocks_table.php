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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calendar_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true); // admin lo apaga/prende
            $table->boolean('is_booked')->default(false); // se ocupa cuando hay cita
            $table->timestamps();
            $table->foreign('calendar_id')
                ->references('id')->on('calendars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
