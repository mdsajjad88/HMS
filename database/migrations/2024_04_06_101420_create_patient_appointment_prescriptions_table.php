<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAppointmentPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_appointment_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->date('prescription_date')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('doctor_assistant_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_request_id')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('doctor_email')->nullable();
            $table->string('doctor_mobile', 20)->nullable();
            $table->string('doctor_address')->nullable();
            $table->string('patient_appointment_number', 30)->nullable();
            $table->dateTime('appointment_date')->nullable();
            $table->string('patient_information')->nullable();
            $table->text('patient_findings')->nullable();
            $table->json('patient_medications')->nullable();
            $table->text('patient_diagnostics')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->name('fk_prescriptions_doctor_chamber');
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->name('fk_prescriptions_org_profile');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->name('fk_prescriptions_doctor_profile');
            $table->foreign('doctor_user_id')->references('id')->on('users')->name('fk_prescriptions_doctor_user');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->name('fk_prescriptions_patient_user');
            $table->foreign('doctor_assistant_id')->references('id')->on('doctor_assistants')->name('fk_prescriptions_doctor_assistant');
            $table->foreign('patient_appointment_request_id')->references('id')->on('patient_appointment_requests')->name('fk_prescriptions_appointment_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_appointment_prescriptions');
    }
}
