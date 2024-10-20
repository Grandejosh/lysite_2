<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsMarginsInveThesisStudentsParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_student_parts', function (Blueprint $table) {
            $table->decimal('right_margin', 4, 2)->nullable();
            $table->decimal('left_margin', 4, 2)->nullable();
        });
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->dropColumn('right_margin');
            $table->dropColumn('left_margin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inve_thesis_student_parts', function (Blueprint $table) {
            $table->dropColumn('between_lines');
            $table->dropColumn('left_margin');
        });
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->decimal('right_margin', 4, 2)->nullable();
            $table->decimal('left_margin', 4, 2)->nullable();
        });
    }
}
