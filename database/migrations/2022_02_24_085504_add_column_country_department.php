<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnCountryDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('country_id',2)->nullable();
            $table->foreign('country_id','departments_country_id_fk')->references('id')->on('countries');
        });

        $query = "UPDATE departments SET country_id = 'PE' WHERE 1";

        DB::select($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign('departments_country_id_fk');
            $table->dropColumn('country_id');
        });
    }
}
