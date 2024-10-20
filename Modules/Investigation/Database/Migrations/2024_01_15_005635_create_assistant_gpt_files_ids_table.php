<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistantGptFilesIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistant_gpt_files_ids', function (Blueprint $table) {
            $table->string('id')->comment("el ID que devuelve OPENAI al subir el archivo");
            $table->string('filename')->comment("Nombre con su extensión que se guarda en el servidor");
            $table->boolean('deleted')->comment("True si ya fue eliminado");
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
        Schema::dropIfExists('assistant_gpt_files_ids');
    }
}
