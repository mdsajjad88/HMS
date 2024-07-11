<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateCallDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_request_id')->nullable();
            $table->string('name', 191)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('blood_group', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email', 191);
            $table->string('mobile', 50)->nullable();
            $table->string('alternative_mobile', 50)->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->text('remarks')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->json('disease_data')->nullable();
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('modified')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Foreign key constraints if necessary
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('set null');
            $table->foreign('patient_appointment_request_id')->references('id')->on('patient_appointment_requests')->onDelete('set null');
            $table->foreign('reason_id')->references('id')->on('reason')->onDelete('set null');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_details');
    }
}
