<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('backup_type')->default('database');
            $table->string('status')->default('pending');
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->string('duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('backup_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
