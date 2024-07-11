<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicMenusClinicRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_menus_clinic_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_menu_id');
            $table->unsignedBigInteger('clinic_role_id');

            // Primary key
            $table->primary(['clinic_menu_id', 'clinic_role_id']);

            // Foreign key constraints
            $table->foreign('clinic_menu_id')->references('id')->on('clinic_menus')->onDelete('cascade');
            $table->foreign('clinic_role_id')->references('id')->on('clinic_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_menus_clinic_roles');
    }
}
