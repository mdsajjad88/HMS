<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->text('comments')->nullable();
            $table->integer('received_from_doctor')->nullable();
            $table->dateTime('prescription_received_date')->nullable();
            $table->integer('send_to_doctor')->nullable();
            $table->dateTime('prescription_sending_date')->nullable();
            $table->tinyInteger('is_current')->default(0);
            $table->dateTime('created')->default(now());
            $table->dateTime('modified')->default(now());
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            // Foreign key constraint
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_doctors');
    }
}
