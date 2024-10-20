<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcaQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aca_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_id');
            $table->text('question_text');
            $table->unsignedBigInteger('user_id');
            $table->boolean('replyed_status')->default(false);
            $table->timestamps();
            $table->foreign('content_id')->references('id')->on('aca_contents');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aca_questions');
    }
}
