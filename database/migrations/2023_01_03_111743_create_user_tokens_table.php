<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('secret_token');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('device_type', 100)->nullable();
            $table->string('device_id', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
           // $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tokens');
    }
}
