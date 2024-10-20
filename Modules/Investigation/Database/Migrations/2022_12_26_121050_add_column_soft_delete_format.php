<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSoftDeleteFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_format_parts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('inve_thesis_formats', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropColumn('deleted_at');
        });
        Schema::table('inve_thesis_format_parts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
