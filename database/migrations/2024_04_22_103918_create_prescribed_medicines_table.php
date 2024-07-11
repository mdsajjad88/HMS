<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribedMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribed_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id');
            $table->unsignedBigInteger('doctor_profile_id')->default(0);
            $table->unsignedBigInteger('prescription_id');
            $table->string('x_medicine_id', 11)->default('0')->comment('medicine_code');
            $table->string('x_medicine_name', 255);
            $table->string('dosage_form', 32)->nullable();
            $table->string('medicine_unit', 32)->nullable()->comment('gm/ml');
            $table->integer('medicine_quantity')->nullable();
            $table->string('taken_instruction', 255)->comment('1+1+0+1');
            $table->text('taken_instruction_detail')->nullable();
            $table->string('stomach_status', 100)->nullable()->comment('empty/full stomach');
            $table->integer('medication_duration')->default(0)->comment('3/5/7 days');
            $table->text('other_instruction')->nullable();
            $table->tinyInteger('is_natural')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);

            // Foreign key constraints
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            // Add other foreign key constraints as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescribed_medicines');
    }
}
