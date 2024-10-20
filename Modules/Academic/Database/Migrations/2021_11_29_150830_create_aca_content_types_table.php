<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAcaContentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aca_content_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('aca_content_types')->insert([
            ['description' => 'Vincula a una dirección externa o interna','name' => 'Enlaces de Video'],
            ['description' => 'Escribir texto','name' => 'Texto'],
            ['description' => 'Subir documentos en pdf o word','name' => 'documento'],
            ['description' => 'Subir imagenes jpg, png','name' => 'Imagen']

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     **/
    public function down()
    {
        Schema::dropIfExists('aca_content_types');
    }
}
