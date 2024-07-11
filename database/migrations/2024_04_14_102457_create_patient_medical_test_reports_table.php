<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientMedicalTestReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_test_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_medical_test_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path');
            $table->string('file_information')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();


            $table->foreign('patient_medical_test_id')->references('id')->on('patient_medical_tests');
            $table->foreign('patient_user_id')->references('id')->on('patient_users');
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
        Schema::dropIfExists('patient_medical_test_reports');
    }
}
