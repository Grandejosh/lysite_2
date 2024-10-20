<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsThesisStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_students', function (Blueprint $table) {
            $table->tinyInteger('top_margin')->nullable();
            $table->tinyInteger('bottom_margin')->nullable();
            $table->tinyInteger('left_margin')->nullable();
            $table->tinyInteger('right_margin')->nullable();
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
            $table->dropColumn('bottom_margin');
            $table->dropColumn('top_margin');
            $table->dropColumn('left_margin');
            $table->dropColumn('right_margin');
        });
    }
}
