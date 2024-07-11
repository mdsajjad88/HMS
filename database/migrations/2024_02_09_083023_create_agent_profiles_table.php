<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id');
            $table->string('type');
            $table->string('name');
            $table->string('code_number')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nid')->nullable();
            $table->string('organization_website')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('status');
            $table->string('photo')->nullable();
            $table->string('photo_dir')->nullable();
            $table->string('contract_document')->nullable();
            $table->unsignedBigInteger('agent_commission_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('modified')->nullable();

            // Foreign key constraints
             $table->foreign('organization_profile_id')->references('id')->on('organization_profiles')->onDelete('cascade');
             $table->foreign('parent_id')->references('id')->on('agent_profiles')->onDelete('set null');
             $table->foreign('agent_commission_id')->references('id')->on('agent_commission')->onDelete('set null');
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
        Schema::dropIfExists('agent_profiles');
    }
}
