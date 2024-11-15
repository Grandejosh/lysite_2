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
        Schema::create('complaint_books_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_book_id');
            $table->string('subject');
            $table->string('email');
            $table->string('complaint_book_status');
            $table->text('message');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_books_replies');
    }
};
