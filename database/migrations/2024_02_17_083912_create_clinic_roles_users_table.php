<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicRolesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_roles_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_role_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            // Primary key
           // $table->primary(['clinic_role_id', 'user_id']);

            // Foreign key constraints
            $table->foreign('clinic_role_id')->references('id')->on('clinic_roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_roles_users');
    }
}
