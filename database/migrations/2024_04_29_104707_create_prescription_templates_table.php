<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('doctor_chamber_id')->nullable();
            $table->json('template');
            $table->timestamp('created')->default(now());
            $table->timestamp('modified')->nullable()->useCurrent();
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('doctor_chamber_id')->references('id')->on('doctor_chambers')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_templates');
    }
}
