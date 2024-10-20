<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInveThesiFormatPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inve_thesis_format_parts', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->text('information');
            $table->string('number_order')->default(0);
            $table->unsignedBigInteger('content_id')->nullable();
            $table->unsignedBigInteger('thesis_format_id')->nullable();
            $table->unsignedBigInteger('belongs')->nullable();
            $table->boolean('body')->default(false);
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('content_id')->references('id')->on('aca_contents');
            $table->foreign('thesis_format_id')->references('id')->on('inve_thesis_formats');
            $table->foreign('belongs')->references('id')->on('inve_thesis_format_parts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inve_thesi_format_parts');
    }
}
