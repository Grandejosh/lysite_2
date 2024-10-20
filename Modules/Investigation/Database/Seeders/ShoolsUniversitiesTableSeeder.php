<?php

namespace Modules\Investigation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShoolsUniversitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('universities_schools')->insert([
            ['name' => 'Administración','university_id' => 142],
            ['name' => 'Contabilidad','university_id' => 142],
            ['name' => 'Derecho','university_id' => 142],
            ['name' => 'Educación','university_id' => 142],
            ['name' => 'Enfermería','university_id' => 142],
            ['name' => 'Farmacia y Biquímica','university_id' => 142],
            ['name' => 'Ingeniería civil','university_id' => 142],
            ['name' => 'Ingeniería de sistemas','university_id' => 142],
            ['name' => 'Obstetricia','university_id' => 142],
            ['name' => 'Odontología','university_id' => 142],
            ['name' => 'Psicología','university_id' => 142]
        ]);

        DB::table('inve_thesis_formats')->insert([
            [
                'name' => 'Formato 01',
                'description' => 'Formato 01',
                'type_thesis' => 'descriptiva',
                'normative_thesis' => 'APA',
                'school_id' => 8
            ]
        ]);
    }
}
