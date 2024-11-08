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
        Schema::create('complaint_books', function (Blueprint $table) {
            $table->id();
            $table->date('date_register')->nullable();
            $table->string('full_name')->nullable();
            $table->string('dni_number')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('ubigeo')->nullable();
            $table->string('address')->nullable();
            $table->string('serie', 6)->nullable();
            $table->string('number', 20)->nullable();
            $table->string('type', 15)->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->text('improvement')->nullable();
            $table->unsignedBigInteger('registers_user_id')->nullable();
            $table->unsignedBigInteger('attends_user_id')->nullable();
            $table->char('status', 1)->default('1')->comment('1=pendiente,2=atendido');
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
        Schema::dropIfExists('complaint_books');
    }
};
