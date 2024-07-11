<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreatePatientMedicalTestMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_test_mappings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_medical_test_id')->nullable();
            $table->unsignedBigInteger('medical_test_id')->nullable();
            $table->unsignedBigInteger('lab_location_id')->nullable();
            $table->tinyInteger('quantity')->default(1);
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->double('discount', 8, 2)->default(0.00);
            $table->double('price', 8, 2)->default(0.00);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->dateTime('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Indexes or Foreign key constraints if needed
            $table->foreign('patient_medical_test_id')->references('id')->on('patient_medical_tests');
            $table->foreign('medical_test_id')->references('id')->on('medical_tests');
            $table->foreign('lab_location_id')->references('id')->on('lab_locations');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_medical_test_mappings');
    }
}
