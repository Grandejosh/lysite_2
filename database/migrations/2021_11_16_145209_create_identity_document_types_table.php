<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIdentityDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_document_types', function (Blueprint $table) {
            $table->string('id',2)->index();
            $table->string('description');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('identity_document_types')->insert([
            ['id' => '0', 'status' => true,  'description' => 'Doc.trib.no.dom.sin.ruc'],
            ['id' => '1', 'status' => true,  'description' => 'DNI'],
            ['id' => '4', 'status' => true,  'description' => 'CE'],
            ['id' => '6', 'status' => true,  'description' => 'RUC'],
            ['id' => '7', 'status' => true,  'description' => 'Pasaporte'],
            ['id' => 'A', 'status' => false, 'description' => 'Ced. Diplomática de identidad'],
            ['id' => 'B', 'status' => false, 'description' => 'Documento identidad país residencia-no.d'],
            ['id' => 'C', 'status' => false, 'description' => 'Tax Identification Number - TIN – Doc Trib PP.NN'],
            ['id' => 'D', 'status' => false, 'description' => 'Identification Number - IN – Doc Trib PP. JJ'],
            ['id' => 'E', 'status' => false, 'description' => 'TAM- Tarjeta Andina de Migración'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_document_types');
    }
}
