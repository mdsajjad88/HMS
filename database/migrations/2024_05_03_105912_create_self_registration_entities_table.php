<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfRegistrationEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_registration_entities', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type')->nullable();
            $table->string('name', 64)->nullable();
            $table->string('email', 32)->nullable(false);
            $table->string('mobile', 16)->nullable(false);
            $table->string('verification_link', 255)->nullable();
            $table->string('verification_code', 8)->nullable();
            $table->tinyInteger('is_verified')->nullable();
            $table->dateTime('verification_date')->nullable();
            $table->text('user_agent')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('self_registration_entities');
    }
}
