<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados')->insert([
            ['id' => 1, 'nombre' => 'Aguascalientes', 'clave' => 'AGS', 'activo' => 1],
            ['id' => 2, 'nombre' => 'Baja California', 'clave' => 'BC', 'activo' => 1],
            ['id' => 3, 'nombre' => 'Baja California Sur', 'clave' => 'BCS', 'activo' => 1],
            ['id' => 4, 'nombre' => 'Campeche', 'clave' => 'CAMP', 'activo' => 1],
            ['id' => 5, 'nombre' => 'Coahuila de Zaragoza', 'clave' => 'COAH', 'activo' => 1],
            ['id' => 6, 'nombre' => 'Colima', 'clave' => 'COL', 'activo' => 1],
            ['id' => 7, 'nombre' => 'Chiapas', 'clave' => 'CHIS', 'activo' => 1],
            ['id' => 8, 'nombre' => 'Chihuahua', 'clave' => 'CHIH', 'activo' => 1],
            ['id' => 9, 'nombre' => 'Ciudad de México', 'clave' => 'CDMX', 'activo' => 1],
            ['id' => 10, 'nombre' => 'Durango', 'clave' => 'DGO', 'activo' => 1],
            ['id' => 11, 'nombre' => 'Guanajuato', 'clave' => 'GTO', 'activo' => 1],
            ['id' => 12, 'nombre' => 'Guerrero', 'clave' => 'GRO', 'activo' => 1],
            ['id' => 13, 'nombre' => 'Hidalgo', 'clave' => 'HGO', 'activo' => 1],
            ['id' => 14, 'nombre' => 'Jalisco', 'clave' => 'JAL', 'activo' => 1],
            ['id' => 15, 'nombre' => 'México', 'clave' => 'MEX', 'activo' => 1],
            ['id' => 16, 'nombre' => 'Michoacán de Ocampo', 'clave' => 'MICH', 'activo' => 1],
            ['id' => 17, 'nombre' => 'Morelos', 'clave' => 'MOR', 'activo' => 1],
            ['id' => 18, 'nombre' => 'Nayarit', 'clave' => 'NAY', 'activo' => 1],
            ['id' => 19, 'nombre' => 'Nuevo León', 'clave' => 'NL', 'activo' => 1],
            ['id' => 20, 'nombre' => 'Oaxaca', 'clave' => 'OAX', 'activo' => 1],
            ['id' => 21, 'nombre' => 'Puebla', 'clave' => 'PUE', 'activo' => 1],
            ['id' => 22, 'nombre' => 'Querétaro', 'clave' => 'QRO', 'activo' => 1],
            ['id' => 23, 'nombre' => 'Quintana Roo', 'clave' => 'QROO', 'activo' => 1],
            ['id' => 24, 'nombre' => 'San Luis Potosí', 'clave' => 'SLP', 'activo' => 1],
            ['id' => 25, 'nombre' => 'Sinaloa', 'clave' => 'SIN', 'activo' => 1],
            ['id' => 26, 'nombre' => 'Sonora', 'clave' => 'SON', 'activo' => 1],
            ['id' => 27, 'nombre' => 'Tabasco', 'clave' => 'TAB', 'activo' => 1],
            ['id' => 28, 'nombre' => 'Tamaulipas', 'clave' => 'TAMP', 'activo' => 1],
            ['id' => 29, 'nombre' => 'Tlaxcala', 'clave' => 'TLAX', 'activo' => 1],
            ['id' => 30, 'nombre' => 'Veracruz de Ignacio de la Llave', 'clave' => 'VER', 'activo' => 1],
            ['id' => 31, 'nombre' => 'Yucatán', 'clave' => 'YUC', 'activo' => 1],
            ['id' => 32, 'nombre' => 'Zacatecas', 'clave' => 'ZAC', 'activo' => 1],
        ]);
    }
}
