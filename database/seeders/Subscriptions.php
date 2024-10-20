<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Subscriptions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_subscriptions')->insert([
            [
                'name' => 'MODO GRATUITO',
                'detail_one' => 'TEMPORAL',
                'detail_two' => 'Acceso ilimitado a los cursos',
                'detail_three' => 'Acceso ilimitado a las herramientas IA',
                'detail_four' => '1500 oportunidades en consultas a la IA',
                'detail_five' => '15 días de acompañamiento del asesor virtual',
                'price' => '0.00'
            ],
            [
                'name' => 'MODO STANDAR',
                'detail_one' => 'MENSUAL',
                'detail_two' => 'Acceso ilimitado a los cursos',
                'detail_three' => 'Acceso ilimitado a las herramientas IA',
                'detail_four' => '3500 oportunidades en consultas a la IA',
                'detail_five' => 'Acompañamiento 24 horas del asesor virtual',
                'price' => '150.00'
            ],
            [
                'name' => 'MODO PREMIUM',
                'detail_one' => 'MENSUAL',
                'detail_two' => 'Acceso ilimitado a los cursos',
                'detail_three' => 'Acceso ilimitado a las herramientas IA',
                'detail_four' => 'Oportunidades ilimitadas en consultas a la IA',
                'detail_five' => 'Acompañamiento 24 horas del asesor virtual',
                'price' => '250.00'
            ]
        ]);
    }
}
