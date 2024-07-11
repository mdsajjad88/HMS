<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->tinyInteger('types')->default(1);
            $table->longText('description')->nullable();
            $table->double('price', 8, 2)->default(0.00);
            $table->integer('sample_collection_room_number')->nullable();
            $table->json('lab_location_id')->nullable();
            $table->integer('status')->default(0);
            $table->string('discount_type', 255)->nullable();
            $table->double('discount', 8, 2)->default(0.00);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes

            // Foreign key constraints (if needed)
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_tests');
    }
}
