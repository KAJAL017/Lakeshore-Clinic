<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_availability_id')->nullable()->constrained('doctor_availability')->nullOnDelete();
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration')->default(30);
            $table->boolean('is_available')->default(true);
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index('doctor_id');
            $table->index('day');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
