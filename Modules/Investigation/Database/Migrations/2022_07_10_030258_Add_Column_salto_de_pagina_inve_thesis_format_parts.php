<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSaltoDePaginaInveThesisFormatParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inve_thesis_format_parts', function (Blueprint $table) {
            $table->boolean('salto_de_pagina')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inve_thesis_format_parts', function (Blueprint $table) {
            $table->dropColumn('salto_de_pagina');
        });
    }
}
