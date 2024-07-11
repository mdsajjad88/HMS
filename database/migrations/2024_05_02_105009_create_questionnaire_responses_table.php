<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questionnaire_template_id')->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->unsignedBigInteger('patient_appointment_request_id')->nullable();
            $table->unsignedBigInteger('patient_user_id')->nullable();
            $table->json('response')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->longText('html_response')->nullable();

            // Foreign key constraints
            $table->foreign('questionnaire_template_id')->references('id')->on('questionnaire_templates');
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles');
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers');
            $table->foreign('patient_appointment_request_id')->references('id')->on('patient_appointment_requests');
            $table->foreign('patient_user_id')->references('id')->on('patient_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_responses');
    }
}
