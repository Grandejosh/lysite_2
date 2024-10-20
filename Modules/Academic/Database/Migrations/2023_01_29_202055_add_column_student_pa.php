<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStudentPa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('aca_students', function (Blueprint $table) {
            $table->integer('allowed_paraphrase')->nullable();
            $table->integer('used_paraphrase')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aca_students', function (Blueprint $table) {
            $table->dropColumn('allowed_paraphrase');
            $table->dropColumn('used_paraphrase');
        });
    }
}
