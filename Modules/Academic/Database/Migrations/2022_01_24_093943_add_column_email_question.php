<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEmailQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aca_questions', function (Blueprint $table) {
            $table->string('question_title',300);
            $table->boolean('email')->default(false)->comment('si esta activo manda correo cada que publican una respuesta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aca_questions', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('question_title');
        });
    }
}
