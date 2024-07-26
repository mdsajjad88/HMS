<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memo_id');
            $table->text('content');
            $table->unsignedBigInteger('user_id');
            $table->longText('edit_history')->nullable();
            $table->timestamps();
            // Define foreign key constraints
            // Uncomment and adjust if you have foreign keys defined
            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memo_notes');
    }
}
