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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('diagnosis_id')->nullable()->after('patient_id');
            $table->foreign('diagnosis_id')
                  ->references('id')
                  ->on('diagnoses_and_prescriptions') // الاسم الصحيح للجدول
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['diagnosis_id']);
            $table->dropColumn('diagnosis_id');
        });
    }
};
