<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationApprovalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_approval_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_profile_id')->nullable();
            $table->dateTime('permission_date')->nullable();
            $table->unsignedBigInteger('x_permission_license_type_id')->nullable();
            $table->string('permission_authority', 255)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->text('permission_conditions')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('organization_profile_id', 'fk_org_approval_org_profile')
                  ->references('id')
                  ->on('organization_profiles')
                  ->onDelete('cascade');

            $table->foreign('x_permission_license_type_id', 'fk_org_approval_license_type')
                  ->references('id')
                  ->on('x_permission_license_types')
                  ->onDelete('set null');

            $table->foreign('created_by', 'fk_org_approval_created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('modified_by', 'fk_org_approval_modified_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_approval_information');
    }
}
