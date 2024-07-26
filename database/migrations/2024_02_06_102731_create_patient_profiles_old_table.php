<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientProfilesOldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_profiles_old', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_user_id')->unsigned();
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255);
            $table->string('mobile', 20);
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('nid')->nullable();
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
            $table->tinyInteger('is_active')->nullable();
            $table->tinyInteger('is_deceased')->nullable();
            $table->text('remarks')->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('nick_name', 255)->nullable();
            $table->string('address_alt', 255)->nullable();
            $table->string('address2_alt', 255)->nullable();
            $table->string('city_alt', 255)->nullable();
            $table->string('state_alt', 255)->nullable();
            $table->string('post_code_alt', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('patient_user_id')->references('id')->on('patient_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_profiles_old');
    }
}
