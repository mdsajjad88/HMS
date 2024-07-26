<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathologistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathologist_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pathologist_user_id')->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255);
            $table->string('mobile', 20);
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('geo_division_id')->nullable();
            $table->unsignedBigInteger('geo_district_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->datetime('created')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->datetime('modified')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('photo_dir', 100)->nullable();
            $table->integer('nid')->nullable();
            $table->string('blood_group', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamps();
            // Foreign key constraints (if needed)
            $table->foreign('pathologist_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('geo_division_id')->references('id')->on('geo_divisions')->onDelete('cascade');
            $table->foreign('geo_district_id')->references('id')->on('geo_districts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // Adjust the table names ('users') as per your actual table names

            // Timestamps for tracking
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathologist_profiles');
    }
}
