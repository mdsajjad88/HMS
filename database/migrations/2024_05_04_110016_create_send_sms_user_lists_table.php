<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateSendSmsUserListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_sms_user_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('mobile', 40)->nullable(false);
            $table->string('email', 255)->nullable();
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->string('helped_by', 255)->nullable();
            $table->timestamps();

            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles');
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
        Schema::dropIfExists('send_sms_user_lists');
    }
}
