->nullable()<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSanctionedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_sanctioned_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->unsignedBigInteger('x_first_division_code_id')->nullable();
            $table->unsignedBigInteger('x_second_division_code_id')->nullable();
            $table->string('sanction_post_code', 50);
            $table->string('sanction_post_class')->nullable();
            $table->string('sanction_post_rank')->nullable();
            $table->string('sanction_post_name', 255);
            $table->string('sanction_post_decipline')->nullable();
            $table->string('sanction_post_type', 100)->nullable();
            $table->string('sanction_post_professional_category', 100)->nullable();
            $table->unsignedBigInteger('x_who_major_group_id')->nullable();
            $table->unsignedBigInteger('x_who_isco_occupation_id')->nullable();
            $table->text('recruitment_rules')->nullable();
            $table->datetime('created')->nullable();
            $table->datetime('modified')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            // Foreign key constraints (if needed)
            $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
            $table->foreign('x_first_division_code_id')->references('id')->on('x_first_division_codes')->onDelete('cascade');
            $table->foreign('x_second_division_code_id')->references('id')->on('x_second_division_codes')->onDelete('cascade');
            $table->foreign('x_who_major_group_id')->references('id')->on('x_who_major_groups')->onDelete('cascade');
            $table->foreign('x_who_isco_occupation_id')->references('id')->on('x_who_isco_occupations')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            // Add more foreign key constraints as per your application's needs
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_sanctioned_posts');
    }
}
