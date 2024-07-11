<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientReportAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_report_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_report_id')->unsigned();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_information', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->tinyInteger('file_secret')->default(0);
            $table->dateTime('report_added_on');
            $table->dateTime('created');
            $table->dateTime('modified');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            // Foreign key constraint
            $table->foreign('patient_report_id')->references('id')->on('patient_reports')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_report_attachments');
    }
}
