<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('municipios')->delete();

        $municipios = [
            ['id' => 1,  'estado_id' => 8, 'nombre' => 'Ahumada'],
            ['id' => 2,  'estado_id' => 8, 'nombre' => 'Aldama'],
            ['id' => 3,  'estado_id' => 8, 'nombre' => 'Allende'],
            ['id' => 4,  'estado_id' => 8, 'nombre' => 'Aquiles Serdán'],
            ['id' => 5,  'estado_id' => 8, 'nombre' => 'Ascensión'],
            ['id' => 6,  'estado_id' => 8, 'nombre' => 'Bachíniva'],
            ['id' => 7,  'estado_id' => 8, 'nombre' => 'Balleza'],
            ['id' => 8,  'estado_id' => 8, 'nombre' => 'Batopilas de Manuel Gómez Morín'],
            ['id' => 9,  'estado_id' => 8, 'nombre' => 'Bocoyna'],
            ['id' => 10, 'estado_id' => 8, 'nombre' => 'Buenaventura'],
            ['id' => 11, 'estado_id' => 8, 'nombre' => 'Camargo'],
            ['id' => 12, 'estado_id' => 8, 'nombre' => 'Carichí'],
            ['id' => 13, 'estado_id' => 8, 'nombre' => 'Casas Grandes'],
            ['id' => 14, 'estado_id' => 8, 'nombre' => 'Coronado'],
            ['id' => 15, 'estado_id' => 8, 'nombre' => 'Coyame del Sotol'],
            ['id' => 16, 'estado_id' => 8, 'nombre' => 'La Cruz'],
            ['id' => 17, 'estado_id' => 8, 'nombre' => 'Cuauhtémoc'],
            ['id' => 18, 'estado_id' => 8, 'nombre' => 'Cusihuiriachi'],
            ['id' => 19, 'estado_id' => 8, 'nombre' => 'Chínipas'],
            ['id' => 20, 'estado_id' => 8, 'nombre' => 'Delicias'],
            ['id' => 21, 'estado_id' => 8, 'nombre' => 'Dr. Belisario Domínguez'],
            ['id' => 22, 'estado_id' => 8, 'nombre' => 'Galeana'],
            ['id' => 23, 'estado_id' => 8, 'nombre' => 'Santa Isabel'],
            ['id' => 24, 'estado_id' => 8, 'nombre' => 'Gómez Farías'],
            ['id' => 25, 'estado_id' => 8, 'nombre' => 'Gran Morelos'],
            ['id' => 26, 'estado_id' => 8, 'nombre' => 'Guachochi'],
            ['id' => 27, 'estado_id' => 8, 'nombre' => 'Guadalupe'],
            ['id' => 28, 'estado_id' => 8, 'nombre' => 'Guadalupe y Calvo'],
            ['id' => 29, 'estado_id' => 8, 'nombre' => 'Guazapares'],
            ['id' => 30, 'estado_id' => 8, 'nombre' => 'Guerrero'],
            ['id' => 31, 'estado_id' => 8, 'nombre' => 'Hidalgo del Parral'],
            ['id' => 32, 'estado_id' => 8, 'nombre' => 'Huejotitán'],
            ['id' => 33, 'estado_id' => 8, 'nombre' => 'Ignacio Zaragoza'],
            ['id' => 34, 'estado_id' => 8, 'nombre' => 'Janos'],
            ['id' => 35, 'estado_id' => 8, 'nombre' => 'Jiménez'],
            ['id' => 36, 'estado_id' => 8, 'nombre' => 'Juárez'],
            ['id' => 37, 'estado_id' => 8, 'nombre' => 'Julimes'],
            ['id' => 38, 'estado_id' => 8, 'nombre' => 'López'],
            ['id' => 39, 'estado_id' => 8, 'nombre' => 'Madera'],
            ['id' => 40, 'estado_id' => 8, 'nombre' => 'Maguarichi'],
            ['id' => 41, 'estado_id' => 8, 'nombre' => 'Manuel Benavides'],
            ['id' => 42, 'estado_id' => 8, 'nombre' => 'Matachí'],
            ['id' => 43, 'estado_id' => 8, 'nombre' => 'Matamoros'],
            ['id' => 44, 'estado_id' => 8, 'nombre' => 'Meoqui'],
            ['id' => 45, 'estado_id' => 8, 'nombre' => 'Morelos'],
            ['id' => 46, 'estado_id' => 8, 'nombre' => 'Moris'],
            ['id' => 47, 'estado_id' => 8, 'nombre' => 'Namiquipa'],
            ['id' => 48, 'estado_id' => 8, 'nombre' => 'Nonoava'],
            ['id' => 49, 'estado_id' => 8, 'nombre' => 'Nuevo Casas Grandes'],
            ['id' => 50, 'estado_id' => 8, 'nombre' => 'Ocampo'],
            ['id' => 51, 'estado_id' => 8, 'nombre' => 'Ojinaga'],
            ['id' => 52, 'estado_id' => 8, 'nombre' => 'Praxedis G. Guerrero'],
            ['id' => 53, 'estado_id' => 8, 'nombre' => 'Riva Palacio'],
            ['id' => 54, 'estado_id' => 8, 'nombre' => 'Rosales'],
            ['id' => 55, 'estado_id' => 8, 'nombre' => 'Rosario'],
            ['id' => 56, 'estado_id' => 8, 'nombre' => 'San Francisco de Borja'],
            ['id' => 57, 'estado_id' => 8, 'nombre' => 'San Francisco de Conchos'],
            ['id' => 58, 'estado_id' => 8, 'nombre' => 'San Francisco del Oro'],
            ['id' => 59, 'estado_id' => 8, 'nombre' => 'Santa Bárbara'],
            ['id' => 60, 'estado_id' => 8, 'nombre' => 'Satevó'],
            ['id' => 61, 'estado_id' => 8, 'nombre' => 'Saucillo'],
            ['id' => 62, 'estado_id' => 8, 'nombre' => 'Temósachic'],
            ['id' => 63, 'estado_id' => 8, 'nombre' => 'El Tule'],
            ['id' => 64, 'estado_id' => 8, 'nombre' => 'Urique'],
            ['id' => 65, 'estado_id' => 8, 'nombre' => 'Uruachi'],
            ['id' => 66, 'estado_id' => 8, 'nombre' => 'Valle de Zaragoza'],
            ['id' => 67, 'estado_id' => 8, 'nombre' => 'Chihuahua'],
        ];

        DB::table('municipios')->insert($municipios);
    }
}