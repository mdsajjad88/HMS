<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAppointmentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_appointment_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_user_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_request_id')->nullable();
            $table->tinyInteger('t_type')->comment('1:credit, 2:deduct');
            $table->double('t_amount', 10, 2)->default(0);
            $table->integer('agent_commission_percentage')->default(0);
            $table->integer('agent_commission_amount')->default(0);
            $table->integer('agent_discount_percentage')->default(0);
            $table->integer('agent_discount_amount')->default(0);
            $table->integer('organization_discount_amount')->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->double('subscription_discount', 8, 2)->default(0.00);
            $table->string('t_txid', 50);
            $table->text('t_log')->nullable();
            $table->tinyInteger('t_status')->default(0);
            $table->string('t_media', 100)->nullable()->comment('bkash, roket, etc.');
            $table->string('t_number', 30)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->dateTime('transaction_requested_at')->nullable();
            $table->dateTime('transaction_approved_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('modified_by')->default(0);
            $table->string('helped_by', 191)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers');
            $table->foreign('patient_appointment_request_id')->references('id')->on('patient_appointment_requests')->onDelete('cascade')->name('fk_app_transaction_app_request');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles');
            $table->foreign('doctor_user_id')->references('id')->on('users');
            $table->foreign('patient_user_id')->references('id')->on('patient_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_appointment_transactions');
    }
}
