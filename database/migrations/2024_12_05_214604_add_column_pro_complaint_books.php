<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_books', function (Blueprint $table) {
            $table->char('type_item', 1)->default('1')->comment('1=producto,2=servicio');
            $table->string('guardian_parents', 1)->nullable()->comment('PARA EL CASO DE MENORES DE EDAD');
            $table->string('identifier_year', 20)->nullable()->comment('000000001-202X');
            $table->date('response_date')->nullable()->comment('FECHA DE COMUNICACIÓN DE LA RESPUESTA');
            $table->date('response_description')->nullable()->comment('descripcion de la respuesta del administrador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaint_books', function (Blueprint $table) {
            $table->dropColumn('response_description');
            $table->dropColumn('response_date');
            $table->dropColumn('identifier_year');
            $table->dropColumn('guardian_parents');
            $table->dropColumn('type_item');
        });
    }
};
