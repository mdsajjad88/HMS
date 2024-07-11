<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->string('password', 255);
            $table->string('login_alias', 50)->nullable();
            $table->tinyInteger('change_password')->default(0);
            $table->tinyInteger('active')->default(0);
            $table->string('user_body', 255)->nullable();
            $table->datetime('created')->nullable();
            $table->datetime('modified')->nullable();
            $table->bigInteger('created_by')->default(0);
            $table->bigInteger('modified_by')->default(0);
            $table->timestamps(); // This will create `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_users');
    }
}
