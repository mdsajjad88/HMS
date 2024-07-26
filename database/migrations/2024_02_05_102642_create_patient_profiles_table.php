<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_user_id')->unsigned();
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255);
            $table->string('mobile', 20);
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nid', 31)->nullable();
            $table->string('disease_id', 191)->nullable();
            $table->integer('age')->nullable();
            $table->integer('created_by')->nullable();
            $table->datetime('created');
            $table->integer('modified_by')->nullable();
            $table->datetime('modified');
            $table->string('photo', 255)->nullable();
            $table->string('photo_dir', 150)->nullable();
            $table->string('blood_group', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('marital_status', 31)->default('0');
            $table->decimal('height_cm', 10, 2)->nullable();
            $table->decimal('weight_kg', 10, 0)->nullable();
            $table->decimal('body_fat_percentage', 10, 2)->nullable();
            $table->string('home_phone', 15)->nullable();
            $table->string('work_phone', 15)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->integer('post_code')->nullable();
            $table->string('country', 255)->nullable();
            $table->string('emergency_contact_person', 255)->nullable();
            $table->string('emergency_phone', 15)->nullable();
            $table->string('emergency_relation', 255)->nullable();
            $table->tinyInteger('has_text_consent')->nullable();
            $table->tinyInteger('text_reminder')->nullable();
            $table->tinyInteger('email_reminder')->nullable();
            $table->string('insurance_payer_name', 255)->nullable();
            $table->string('insurance_payer_id', 255)->nullable();
            $table->string('insurance_plan', 255)->nullable();
            $table->string('insurance_group', 255)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('referral', 255)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_deceased')->nullable();
            $table->text('remarks')->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('nick_name', 255)->nullable();
            $table->string('address_alt', 255)->nullable();
            $table->string('address2_alt', 255)->nullable();
            $table->string('city_alt', 255)->nullable();
            $table->string('state_alt', 255)->nullable();
            $table->string('post_code_alt', 255)->nullable();
            $table->integer('patient_type_id')->nullable();
            $table->longText('internal_comments')->nullable();
            $table->string('profession', 255)->nullable();
            $table->string('marketing_source_by', 50)->nullable();
            $table->string('marketing_source', 255)->nullable();
            $table->string('agent_code_number', 255)->nullable();
            $table->unsignedBigInteger('geo_division_id')->nullable();
            $table->unsignedBigInteger('geo_district_id')->nullable();
            $table->unsignedBigInteger('geo_upazila_id')->nullable();
            $table->timestamps();
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
            $table->foreign('geo_division_id')->references('id')->on('geo_districts')->onDelete('cascade');
            $table->foreign('geo_district_id')->references('id')->on('geo_districts')->onDelete('cascade');
            $table->foreign('geo_upazila_id')->references('id')->on('geo_upazilas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_profiles');
    }
}
