<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationLandInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_land_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->double('land_size');
            $table->string('mouza_name', 100);
            $table->string('geo_code', 10);
            $table->text('jl_number')->nullable();
            $table->text('ss_dag')->nullable();
            $table->text('rs_dag')->nullable();
            $table->text('khatian')->nullable();
            $table->text('mutation_info')->nullable();
            $table->text('other')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

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
        Schema::dropIfExists('organization_land_information');
    }
}
