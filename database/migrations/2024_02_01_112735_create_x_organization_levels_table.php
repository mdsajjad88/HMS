<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOrganizationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_organization_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level_code')->nullable(false);
            $table->string('level_name', 255)->nullable(false);
            $table->dateTime('created')->nullable(false);
            $table->dateTime('modified')->nullable(false);
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('x_organization_levels');
    }
}
