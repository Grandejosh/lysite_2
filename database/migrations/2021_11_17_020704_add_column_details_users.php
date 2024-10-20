<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDetailsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->text('description')->nullable();
            $table->boolean('np')->default(true)->comment('mostrar nombre completo a todos');
            $table->boolean('pp')->default(true)->comment('perfil de usuario publico');
            $table->boolean('tn')->default(false)->comment('notificaciones de tutorias nuevas');
            $table->boolean('ncr')->default(false)->comment('Nuevos tutorias futuros');
            $table->boolean('pfp')->default(false)->comment('Nuevos productos y funciones');
            $table->boolean('eft')->default(false)->comment('correos del maestro');
            $table->boolean('cs')->default(false)->comment('Sugerencias de contenido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cs');
            $table->dropColumn('eft');
            $table->dropColumn('pfp');
            $table->dropColumn('ncr');
            $table->dropColumn('tn');
            $table->dropColumn('pp');
            $table->dropColumn('np');
            $table->dropColumn('description');
            $table->dropColumn('avatar');
        });
    }
}
