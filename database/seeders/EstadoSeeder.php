<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados')->delete();

        $estados = [
            ['id' => 1,  'nombre' => 'Aguascalientes', 'clave' => 'AGS'],
            ['id' => 2,  'nombre' => 'Baja California', 'clave' => 'BC'],
            ['id' => 3,  'nombre' => 'Baja California Sur', 'clave' => 'BCS'],
            ['id' => 4,  'nombre' => 'Campeche', 'clave' => 'CAMP'],
            ['id' => 5,  'nombre' => 'Coahuila de Zaragoza', 'clave' => 'COAH'],
            ['id' => 6,  'nombre' => 'Colima', 'clave' => 'COL'],
            ['id' => 7,  'nombre' => 'Chiapas', 'clave' => 'CHIS'],
            ['id' => 8,  'nombre' => 'Chihuahua', 'clave' => 'CHIH'],
            ['id' => 9,  'nombre' => 'Ciudad de México', 'clave' => 'CDMX'],
            ['id' => 10, 'nombre' => 'Durango', 'clave' => 'DGO'],
            ['id' => 11, 'nombre' => 'Guanajuato', 'clave' => 'GTO'],
            ['id' => 12, 'nombre' => 'Guerrero', 'clave' => 'GRO'],
            ['id' => 13, 'nombre' => 'Hidalgo', 'clave' => 'HGO'],
            ['id' => 14, 'nombre' => 'Jalisco', 'clave' => 'JAL'],
            ['id' => 15, 'nombre' => 'México', 'clave' => 'MEX'],
            ['id' => 16, 'nombre' => 'Michoacán de Ocampo', 'clave' => 'MICH'],
            ['id' => 17, 'nombre' => 'Morelos', 'clave' => 'MOR'],
            ['id' => 18, 'nombre' => 'Nayarit', 'clave' => 'NAY'],
            ['id' => 19, 'nombre' => 'Nuevo León', 'clave' => 'NL'],
            ['id' => 20, 'nombre' => 'Oaxaca', 'clave' => 'OAX'],
            ['id' => 21, 'nombre' => 'Puebla', 'clave' => 'PUE'],
            ['id' => 22, 'nombre' => 'Querétaro', 'clave' => 'QRO'],
            ['id' => 23, 'nombre' => 'Quintana Roo', 'clave' => 'QROO'],
            ['id' => 24, 'nombre' => 'San Luis Potosí', 'clave' => 'SLP'],
            ['id' => 25, 'nombre' => 'Sinaloa', 'clave' => 'SIN'],
            ['id' => 26, 'nombre' => 'Sonora', 'clave' => 'SON'],
            ['id' => 27, 'nombre' => 'Tabasco', 'clave' => 'TAB'],
            ['id' => 28, 'nombre' => 'Tamaulipas', 'clave' => 'TAMP'],
            ['id' => 29, 'nombre' => 'Tlaxcala', 'clave' => 'TLAX'],
            ['id' => 30, 'nombre' => 'Veracruz de Ignacio de la Llave', 'clave' => 'VER'],
            ['id' => 31, 'nombre' => 'Yucatán', 'clave' => 'YUC'],
            ['id' => 32, 'nombre' => 'Zacatecas', 'clave' => 'ZAC'],
        ];

        DB::table('estados')->insert($estados);
    }
}