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
        Schema::create('diagnoses_and_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // علاقة مع جدول المرضى
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');  // علاقة مع جدول الأطباء
            $table->text('diagnosis'); // التشخيص
            $table->text('prescription'); // الوصفة الطبية
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses_and_prescriptions');
    }
};
