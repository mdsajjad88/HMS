<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('type_name', 255);
            $table->unsignedBigInteger('appointment_type_id')->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->string('color_code_hex', 15)->nullable();
            $table->string('token_name', 20)->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('service_time_in_minutes')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('appointment_type_id')->references('id')->on('appointment_types')->onDelete('cascade');
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('service_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_types');
    }
}
