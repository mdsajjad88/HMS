<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_and_problems', function (Blueprint $table) {
           $table->unsignedBigInteger('doctor_user_id')->nullable();
           $table->date('last_visited_date')->nullable();
           $table->foreign('doctor_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_and_problems', function (Blueprint $table) {
            $table->dropColumn('doctor_user_id');
            $table->dropColumn('last_visited_date');
        });
    }
};
