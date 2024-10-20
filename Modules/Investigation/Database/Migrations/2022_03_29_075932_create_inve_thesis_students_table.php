<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInveThesisStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inve_thesis_students', function (Blueprint $table) {
            $table->id();
            $table->string('external_id', 10)->nullable();
            $table->string('short_name')->nullable();
            $table->text('title');
            $table->boolean('autosave')->default(true);
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('format_id');
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('student_id')->references('id')->on('aca_students');
            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('university_id')->references('id')->on('universities');
            $table->foreign('school_id')->references('id')->on('universities_schools');
            $table->foreign('format_id')->references('id')->on('inve_thesis_formats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inve_thesis_students');
    }
}
