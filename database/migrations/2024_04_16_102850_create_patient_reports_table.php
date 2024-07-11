<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_reports', function (Blueprint $table) {
            $table->id();
            $table->date('prescription_date')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id');
            $table->string('organization_name', 255)->nullable();
            $table->string('organization_address', 255)->nullable();
            $table->string('doctor_name', 255)->nullable();
            $table->string('doctor_email', 255)->nullable();
            $table->string('doctor_mobile', 20)->nullable();
            $table->string('doctor_address', 255)->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('created');
            $table->dateTime('modified');


            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->onDelete('cascade');
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade');
            $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_reports');
    }
}
