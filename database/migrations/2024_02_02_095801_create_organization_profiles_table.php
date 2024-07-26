<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateOrganizationProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('has_pathology')->default(0);
            $table->unsignedBigInteger('x_agency_id')->nullable();
            $table->unsignedBigInteger('x_revenue_code')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_code', 10)->nullable();
            $table->string('type_name')->nullable();
            $table->string('year_established', 8)->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_dir')->nullable();
            $table->integer('x_ur_location')->nullable()->comment('1-Within city corporation area 2-Within Municipality area 3-Rural');
            $table->integer('x_division')->nullable();
            $table->integer('x_district')->nullable();
            $table->integer('x_upazilla')->nullable();
            $table->integer('x_thana')->nullable();
            $table->integer('x_union')->nullable();
            $table->string('division_name', 100)->nullable();
            $table->string('division_code', 100)->nullable();
            $table->string('district_name', 100)->nullable();
            $table->string('district_code', 100)->nullable();
            $table->string('upzila_name', 100)->nullable();
            $table->string('upzila_code', 100)->nullable();
            $table->integer('post_code')->nullable();
            $table->integer('ward_no')->nullable();
            $table->string('village_name', 64)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('land_phone', 64)->nullable();
            $table->string('mobile_phone', 64)->nullable();
            $table->string('fax_number', 64)->nullable();
            $table->string('email', 64)->nullable();
            $table->text('website')->nullable();
            $table->json('social_media')->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('latitude', 100)->nullable();
            $table->text('map_link')->nullable();
            $table->string('gps', 255)->nullable();
            $table->unsignedBigInteger('x_ownership_authorities_id')->nullable();
            $table->json('x_organization_functions')->nullable();
            $table->unsignedBigInteger('x_organization_type_id')->nullable();
            $table->unsignedBigInteger('x_organization_level_id')->nullable();
            $table->string('health_care_level', 64)->nullable()->comment('1-Primary 2-Secondary 3-Tertiary 4-Not applicable');
            $table->json('x_special_services')->nullable();
            $table->unsignedBigInteger('x_electricity_source_main')->nullable();
            $table->unsignedBigInteger('x_electricity_source_alt')->nullable();
            $table->unsignedBigInteger('x_water_supply_main')->nullable();
            $table->unsignedBigInteger('x_water_supply_alt')->nullable();
            $table->unsignedBigInteger('x_toilet_type')->nullable();
            $table->unsignedBigInteger('x_toilet_adequacy')->nullable();
            $table->json('x_fuel_source')->nullable();
            $table->json('x_laundry')->nullable();
            $table->json('x_autoclave')->nullable();
            $table->json('x_waste_disposal')->nullable();
            $table->text('organizational_functions')->nullable();
            $table->text('sanctioned_vehicles')->nullable();
            $table->text('sanctioned_office_equipments')->nullable();
            $table->json('business_time')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints (if needed)
             $table->foreign('x_agency_id')->references('id')->on('x_agencies')->onDelete('set null');
            // $table->foreign('x_revenue_code')->references('id')->on('revenue_codes')->onDelete('set null');
             $table->foreign('x_ownership_authorities_id')->references('id')->on('x_ownership_authorities')->onDelete('set null');
             $table->foreign('x_organization_type_id')->references('id')->on('x_organization_types')->onDelete('set null');
             $table->foreign('x_organization_level_id')->references('id')->on('x_organization_levels')->onDelete('set null');

            // Add more foreign key constraints as per your application's needs
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_profiles');
    }
}
