<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAppointmentAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_appointment_attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('doctor_assistant_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_request_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_prescription_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_information')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('file_secret')->default(0);
            $table->dateTime('date_added');
            $table->integer('added_patient_user')->nullable();
            $table->integer('added_other_user')->nullable();

            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles');
            $table->foreign('doctor_user_id')->references('id')->on('users');
            $table->foreign('patient_user_id')->references('id')->on('patient_users');
            $table->foreign('doctor_assistant_id')->references('id')->on('doctor_assistants');
            $table->foreign('patient_appointment_request_id')->references('id')->on('patient_appointment_requests')->name('fk_appoint_attac_app_requ');
            $table->foreign('patient_appointment_prescription_id')->references('id')->on('patient_appointment_prescriptions')->name('fk_appoint_attac_app_prescriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_appointment_attachments');
    }
}
