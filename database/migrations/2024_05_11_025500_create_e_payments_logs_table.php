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
        Schema::create('e_payments_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_origin', ['paypal', 'mercadopago', 'yape', 'card']);
            $table->enum('currency', ['USD', 'PEN', 'EUR'])->comment('Tipo de moneda usada');
            $table->decimal('gross_amount', 10, 2)->comment('Monto bruto de depósito');
            $table->decimal('net_amount', 10, 2)->comment('Monto neto que queda para la entidad o empresa');
            $table->decimal('commission', 10, 2)->comment('lo que se cobra paypa, mercadopago u otro');
            $table->enum('status_order', ['PE', 'CA', 'SU'])->comment('PENDING, CANCELED o SUCCESSFUL');
            $table->text('email')->comment('Email del pagador')->nullable();
            $table->text('name')->comment('nombre del pagador')->nullable();
            $table->text('country_origin')->comment('país del pagador')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_payments_logs');
    }
};
