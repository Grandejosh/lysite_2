<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInveThesisStudentIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inve_thesis_student_indices', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('0=general,1=tablas,2=imagen');
            $table->unsignedBigInteger('thesis_id');
            $table->string('prefix')->nullable();
            $table->string('content', 400)->nullable();
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('page', 6)->nullable();
            $table->timestamps();
            $table->foreign('thesis_id')->references('id')->on('inve_thesis_students')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('inve_thesis_student_indices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inve_thesis_student_indices');
    }
}
