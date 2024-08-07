<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicMenusCopy1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_menus_copy1', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sequence')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();

            // Foreign key constraint
            $table->foreign('parent_id')->references('id')->on('clinic_menus_copy1')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_menus_copy1');
    }
}
