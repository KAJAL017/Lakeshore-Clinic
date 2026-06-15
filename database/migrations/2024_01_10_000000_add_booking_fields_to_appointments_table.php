<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('reason')->nullable()->after('notes');
            $table->text('symptoms')->nullable()->after('reason');
            $table->string('patient_name')->nullable()->after('patient_id');
            $table->string('patient_email')->nullable()->after('patient_name');
            $table->string('patient_phone')->nullable()->after('patient_email');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['reason', 'symptoms', 'patient_name', 'patient_email', 'patient_phone']);
        });
    }
};
