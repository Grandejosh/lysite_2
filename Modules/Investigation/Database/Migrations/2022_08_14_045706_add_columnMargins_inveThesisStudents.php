<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMarginsInveThesisStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->decimal('right_margin', 4, 2)->nullable();
            $table->decimal('left_margin', 4, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->dropColumn('between_lines');
            $table->dropColumn('left_margin');
        });
    }
}
