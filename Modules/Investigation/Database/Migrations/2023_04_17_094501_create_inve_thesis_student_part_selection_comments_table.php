<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInveThesisStudentPartSelectionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inve_thesis_student_part_selection_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thesis_student_part_id');
            $table->unsignedBigInteger('thesis_student_id');
            $table->unsignedBigInteger('thesis_format_part_id');
            $table->binary('selecction_text', 16777215);
            $table->string('selecction_id');
            $table->text('commentary');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('inve_thesis_student_part_selection_comments');
    }
}
