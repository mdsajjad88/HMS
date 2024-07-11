<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name', 255);
            $table->string('color_code_hex', 15)->nullable();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->timestamps(); // This will create `created_at` and `updated_at` columns

            // Foreign key constraint
            $table->foreign('organization_profile_id')
                  ->references('id')
                  ->on('organization_profiles')
                  ->onDelete('set null'); // Adjust onDelete as per your requirements
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_types');
    }
}
