<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('memos', function (Blueprint $table) {
        $table->id();
        $table->text('content');
        $table->unsignedBigInteger('user_id');
        $table->tinyInteger('status')->default(0);
        $table->timestamps(); // This will create `created_at` and `updated_at` columns

        // Define foreign key constraint if needed
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
        Schema::dropIfExists('memos');
    }
}
