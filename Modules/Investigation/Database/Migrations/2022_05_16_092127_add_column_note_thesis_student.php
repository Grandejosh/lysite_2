<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNoteThesisStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_student_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('commentary_user_id')->nullable();
            $table->text('commentary')->nullable();
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
            $table->dropColumn('commentary');
            $table->dropColumn('commentary_user_id');
        });
    }
}
