<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('block_id')->nullable();
            $table->dateTime('date');
            $table->string('reason');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
