<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOndelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->dropForeign('inve_thesis_students_student_id_foreign');
            $table->dropForeign('inve_thesis_students_person_id_foreign');
            $table->dropForeign('inve_thesis_students_user_id_foreign');
            $table->dropForeign('inve_thesis_students_university_id_foreign');
            $table->dropForeign('inve_thesis_students_school_id_foreign');
            $table->dropForeign('inve_thesis_students_format_id_foreign');

            $table->foreign('student_id', 'inve_thesis_students_student_id_foreign')->references('id')->on('aca_students')->onDelete('cascade');
            $table->foreign('person_id', 'inve_thesis_students_person_id_foreign')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('user_id', 'inve_thesis_students_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('university_id', 'inve_thesis_students_university_id_foreign')->references('id')->on('universities')->onDelete('cascade');
            $table->foreign('school_id', 'inve_thesis_students_school_id_foreign')->references('id')->on('universities_schools')->onDelete('cascade');
            $table->foreign('format_id', 'inve_thesis_students_format_id_foreign')->references('id')->on('inve_thesis_formats')->onDelete('cascade');
        });

        Schema::table('inve_thesis_student_parts', function (Blueprint $table) {
            $table->dropForeign('tsp_thesis_id_fk');
            $table->dropForeign('tsp_part_id_fk');
            $table->foreign('inve_thesis_student_id', 'tsp_thesis_id_fk')->references('id')->on('inve_thesis_students')->onDelete('cascade');
            $table->foreign('inve_thesis_format_part_id', 'tsp_part_id_fk')->references('id')->on('inve_thesis_format_parts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('inve_thesis_students', function (Blueprint $table) {
    //     });
    // }
}
