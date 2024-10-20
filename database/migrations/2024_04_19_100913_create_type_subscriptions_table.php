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
        Schema::create('type_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('detail_one')->nullable();
            $table->string('detail_two')->nullable();
            $table->string('detail_three')->nullable();
            $table->string('detail_four')->nullable();
            $table->string('detail_five')->nullable();
            $table->string('detail_six')->nullable();
            $table->string('detail_seven')->nullable();
            $table->string('detail_eight')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedBigInteger('created_user_id')->nullable();
            $table->unsignedBigInteger('updated_user_id')->nullable();
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
        Schema::dropIfExists('type_subscriptions');
    }
};
