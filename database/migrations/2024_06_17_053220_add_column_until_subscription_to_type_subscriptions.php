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
        Schema::table('type_subscriptions', function (Blueprint $table) {
            $table->integer('until_subscription')->nullable(); //será un entero numero de meses que se debe sumar a la subscripción si aún no vence o al día actual si ya venció
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_subscriptions', function (Blueprint $table) {
            $table->dropColumn('until_subscription');
        });
    }
};
