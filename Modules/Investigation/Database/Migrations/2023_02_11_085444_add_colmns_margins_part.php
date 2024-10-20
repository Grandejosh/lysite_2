<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColmnsMarginsPart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_student_parts', function (Blueprint $table) {
            $table->decimal('top_margin')->default(2.5);
            $table->decimal('bottom_margin')->default(2.5);
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
            $table->dropColumn('bottom_margin');
            $table->dropColumn('top_margin');
        });
    }
}
