<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTopBottomMargens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_formats', function (Blueprint $table) {
            $table->decimal('top_margin', 4, 2)->nullable();
            $table->decimal('bottom_margin', 4, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inve_thesis_formats', function (Blueprint $table) {
            $table->dropColumn('top_margin');
            $table->dropColumn('bottom_margin');
        });
    }
}
