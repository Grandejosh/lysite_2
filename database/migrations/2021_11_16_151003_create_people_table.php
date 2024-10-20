<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('identity_document_type_id',2);
            $table->string('number');
            $table->string('names')->nullable();
            $table->string('last_name_father')->nullable();
            $table->string('last_name_mother')->nullable();
            $table->string('full_name',500)->nullable();
            $table->string('address')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->char('sex',1)->default('1');
            $table->date('birth_date')->nullable();
            $table->string('email')->nullable();
            $table->char('department_id',2)->nullable();
            $table->char('province_id',4)->nullable();
            $table->char('district_id',6)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('allowed_thesis')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('identity_document_type_id')->references('id')->on('identity_document_types');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
