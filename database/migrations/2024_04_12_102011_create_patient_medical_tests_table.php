<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreatePatientMedicalTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->unsignedBigInteger('doctor_profile_id')->nullable();
            $table->json('medical_test')->nullable();
            $table->integer('status')->default(0);
            $table->integer('types')->default(0);
            $table->integer('collection_charge')->nullable();
            $table->integer('others_discount')->default(0);
            $table->double('amount', 8, 2)->default(0.00);
            $table->double('discount', 8, 2)->default(0.00);
            $table->double('final_total', 8, 2)->default(0.00);
            $table->double('paid_amount', 8, 2)->default(0.00);
            $table->integer('payment_status')->default(0);
            $table->string('remarks', 255)->default('');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->string('helped_by', 255)->nullable();
            $table->timestamp('created')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('modified')->nullable()->default(null);

            // Indexes or Foreign key constraints if needed
            $table->foreign('patient_user_id')->references('id')->on('patient_users');
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profiles');
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
        Schema::dropIfExists('patient_medical_tests');
    }
}
