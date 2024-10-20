<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_histories', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('author');
            $table->text('thesis_title');
            $table->integer('year');
            $table->text('month');
            $table->text('career');
            $table->text('image_path');
            $table->text('university');
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
        Schema::dropIfExists('home_histories');
    }
}
