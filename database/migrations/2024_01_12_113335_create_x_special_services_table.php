<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXSpecialServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_special_services', function (Blueprint $table) {
            $table->id();
            $table->integer('service_code')->nullable(false);
            $table->string('service_name', 255)->nullable(false);
            $table->dateTime('created')->nullable();
            $table->dateTime('modified')->nullable();
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
        Schema::dropIfExists('x_special_services');
    }
}
