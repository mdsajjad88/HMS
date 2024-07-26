<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXPermissionLicenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_permission_license_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_code', 10)->nullable(false);
            $table->string('type_name', 255)->nullable(false);
            $table->dateTime('created')->nullable();
            $table->dateTime('modified')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_permission_license_types');
    }
}
