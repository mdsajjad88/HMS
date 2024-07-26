<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('image_category_id')->nullable();
            $table->text('title')->nullable();
            $table->string('type', 50)->default('Gallery');
            $table->string('photo', 255)->nullable();
            $table->string('photo_dir', 255)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Foreign key constraints (if needed)
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('image_category_id')->references('id')->on('image_categories')->onDelete('set null');
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
        Schema::dropIfExists('organization_galleries');
    }
}
