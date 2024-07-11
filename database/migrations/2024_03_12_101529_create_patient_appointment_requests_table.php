<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAppointmentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_appointment_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('reference_doctor_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id');
            $table->date('request_date');
            $table->json('request_slot');
            $table->unsignedBigInteger('doctor_appointment_slot_id')->nullable();
            $table->unsignedBigInteger('doctor_appointment_day_id')->nullable();
            $table->string('appointment_media')->nullable();
            $table->date('can_visit')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->dateTime('confirm_time')->nullable();
            $table->tinyInteger('confirm_status')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->string('remarks')->nullable();
            $table->tinyInteger('is_visited')->default(0);
            $table->dateTime('visited_date')->nullable();
            $table->integer('created_by')->default(0);
            $table->string('created_name')->nullable();
            $table->integer('modified_by')->default(0);
            $table->string('helped_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('appointment_number', 20)->nullable();
            $table->text('change_history')->nullable();
            $table->string('reference_link', 511)->nullable();
            $table->unsignedBigInteger('appointment_type_id')->nullable();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->string('sub_service_type_ids')->nullable();
            $table->string('patient_referred_by')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('consultation_start_time')->nullable();
            $table->string('end_of_consultation_time')->nullable();
            $table->string('appointment_consultation_time_difference', 8)->nullable();
            $table->string('consultation_duration', 8)->nullable();
            $table->text('comments')->nullable();
            $table->text('opinions')->nullable();
            $table->string('color_code_hex', 20)->nullable();
            $table->unsignedBigInteger('patient_subscription_id')->nullable();
            $table->tinyInteger('is_subscribe')->default(0);
            $table->tinyInteger('special_discount')->default(0);
            $table->tinyInteger('subscription_discount')->default(0);
            $table->string('bill_no', 20)->nullable();
            $table->unsignedBigInteger('service_appointment_slot_id')->nullable();
            $table->unsignedBigInteger('service_appointment_day_id')->nullable();


            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers');
            $table->foreign('reference_doctor_id')->references('id')->on('doctor_profiles');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles');
            $table->foreign('doctor_user_id')->references('id')->on('users');
            $table->foreign('patient_user_id')->references('id')->on('users');
            $table->foreign('confirmed_by')->references('id')->on('users');
            $table->foreign('appointment_type_id')->references('id')->on('appointment_types');
            $table->foreign('service_type_id')->references('id')->on('service_types');
            $table->foreign('patient_subscription_id')->references('id')->on('patient_subscriptions');
            $table->foreign('service_appointment_slot_id')->references('id')->on('service_appointment_slots');
            $table->foreign('service_appointment_day_id')->references('id')->on('service_appointment_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_appointment_requests');
    }
}
