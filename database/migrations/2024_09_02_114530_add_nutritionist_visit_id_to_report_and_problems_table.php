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
            $table->unsignedBigInteger('nutritionist_visit_id')->nullable();
            $table->foreign('nutritionist_visit_id')->references('id')->on('nutritionist_visits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_and_problems', function (Blueprint $table) {
            $table->dropColumn('nutritionist_visit_id');
        });
    }
};
