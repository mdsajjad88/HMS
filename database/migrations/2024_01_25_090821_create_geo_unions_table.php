<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_unions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('geo_upazila_id')->nullable();
            $table->string('upazila_bbs_code')->nullable();
            $table->string('union_name_eng');
            $table->string('union_name_bng')->nullable();
            $table->string('bbs_code')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints


            $table->foreign('geo_upazila_id')->references('id')->on('geo_upazilas')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_unions');
    }
}
