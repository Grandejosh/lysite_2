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
        Schema::table('user_devices', function (Blueprint $table) {
            // Agregar columna VARCHAR con longitud personalizada (opcional)
            $table->string('token', 35)  // 35 caracteres máximo
                  ->nullable()             // Permite valores NULL
                  ->comment('token de verificación');
        });
    }

    public function down()
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
