<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoMunicipalityWardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_municipality_wards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('geo_division_id')->nullable();
            $table->unsignedBigInteger('geo_district_id')->nullable();
            $table->unsignedBigInteger('geo_upazila_id')->nullable();
            $table->unsignedBigInteger('geo_municipality_id')->nullable();
            $table->string('division_bbs_code')->nullable();
            $table->string('district_bbs_code')->nullable();
            $table->string('upazila_bbs_code')->nullable();
            $table->string('municipality_bbs_code')->nullable();
            $table->string('ward_name_eng');
            $table->string('ward_name_bng')->nullable();
            $table->string('bbs_code')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('geo_division_id')->references('id')->on('geo_divisions')->onDelete('cascade');
            $table->foreign('geo_district_id')->references('id')->on('geo_districts')->onDelete('cascade');
            $table->foreign('geo_upazila_id')->references('id')->on('geo_upazilas')->onDelete('set null');
            $table->foreign('geo_municipality_id')->references('id')->on('geo_municipalities')->onDelete('set null');
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
        Schema::dropIfExists('geo_municipality_wards');
    }
}
