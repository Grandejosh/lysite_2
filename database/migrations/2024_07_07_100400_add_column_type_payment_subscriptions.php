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
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->enum('payment_server', ['efectivo', 'mercadopago', 'paypal', 'yape', 'plin'])->nullable()->comment('saber de que plataforma vino el pago');
            $table->boolean('payment_online')->default(true)->comment('si esta en 1 lo hizo el usuario, en 0 lo registro el administrador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropColumn('payment_online');
            $table->dropColumn('payment_server');
        });
    }
};
