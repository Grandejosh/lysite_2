<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_gpt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history_id');
            $table->boolean('my_user')->default(true);
            $table->string('file_original_name')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->foreign('history_id')->references('id')->on('history_gpts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_gpt_items');
    }
};
