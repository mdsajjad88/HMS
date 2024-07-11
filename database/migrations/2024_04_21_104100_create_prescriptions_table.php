<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->nullable()->comment('Patient appointment request id');
            $table->string('prescription_number', 20)->comment('autogenerated prescription number doctor and chamber wise unique');
            $table->datetime('visit_date')->nullable();
            $table->datetime('prescription_date')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->string('membership_number', 32)->nullable();
            $table->string('name', 255);
            $table->float('age');
            $table->string('gender', 32);
            $table->string('current_weight', 64)->nullable();
            $table->string('current_height', 64)->nullable();
            $table->string('body_temp', 64)->nullable();
            $table->string('blood_pressure', 64)->nullable();
            $table->string('diabetic_info', 255)->nullable();
            $table->string('pulse_rate', 64)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->datetime('publish_date')->nullable();
            $table->tinyInteger('share_seen')->default(0);
            $table->datetime('created')->default(now());
            $table->datetime('modified')->default(now());
            $table->text('comments')->nullable();
            $table->longText('diagnoses_others_info')->nullable();
            $table->longText('natural_advise_others_info')->nullable();
            $table->longText('allopathic_advise_others_info')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->longText('template')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('appointment_id')->references('id')->on('patient_appointment_requests');
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
        Schema::dropIfExists('prescriptions');
    }
}
