<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateInveThesisStudentPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inve_thesis_student_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('inve_thesis_student_id');
            $table->unsignedBigInteger('inve_thesis_format_part_id');
            //$table->longText('content')->nullable();
            $table->integer('version')->default(0);
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('inve_thesis_student_id', 'tsp_thesis_id_fk')->references('id')->on('inve_thesis_students');
            $table->foreign('inve_thesis_format_part_id', 'tsp_part_id_fk')->references('id')->on('inve_thesis_format_parts');
        });

        DB::statement("ALTER TABLE inve_thesis_student_parts ADD content MEDIUMBLOB NULL AFTER inve_thesis_format_part_id");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inve_thesis_student_parts');
    }
}
