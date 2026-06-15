<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('license_number')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('years_of_experience')->default(0);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->text('biography')->nullable();
            $table->string('status')->default('pending');
            $table->string('approval_status')->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index('approval_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
