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
        Schema::create('patient_medical_test_medical_test', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_medical_test_id');
            $table->unsignedBigInteger('medical_test_id');
            // Add any additional columns as needed
            $table->timestamps();

            // Define foreign keys
            $table->foreign('patient_medical_test_id')->references('id')->on('patient_medical_tests')->onDelete('cascade')->name('fk_p_medical_test_with_m_test');
            $table->foreign('medical_test_id')->references('id')->on('medical_tests')->onDelete('cascade');

            // Optionally, unique constraint if needed

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medical_test_medical_test');
    }
};
