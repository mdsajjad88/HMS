<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('created')->nullable(false);
            $table->dateTime('modified')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_information', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('added_able', 255)->nullable();
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_attachments');
    }
}
