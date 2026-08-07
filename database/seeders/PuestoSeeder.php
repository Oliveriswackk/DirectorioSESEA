<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuestoSeeder extends Seeder
{
    public function run(): void
    {
        $puestos = [
            [
                'id' => 1,
                'nombre' => 'Presidente',
                'activo' => true,
            ],
            [
                'id' => 2,
                'nombre' => 'Suplente',
                'activo' => true,
            ],
            [
                'id' => 3,
                'nombre' => 'Secretario',
                'activo' => true,
            ],
            [
                'id' => 4,
                'nombre' => 'Secretario de Ayuntamiento',
                'activo' => true,
            ],
            [
                'id' => 5,
                'nombre' => 'Tesorero',
                'activo' => true,
            ],
            [
                'id' => 6,
                'nombre' => 'Oficial Mayor',
                'activo' => true,
            ],
            [
                'id' => 7,
                'nombre' => 'Director de Obras Públicas',
                'activo' => true,
            ],
            [
                'id' => 8,
                'nombre' => 'Director de Seguridad Pública',
                'activo' => true,
            ],
            [
                'id' => 9,
                'nombre' => 'TOIC',
                'activo' => true,
            ],
            [
                'id' => 10,
                'nombre' => 'Enlace SEA',
                'activo' => true,
            ],
            [
                'id' => 11,
                'nombre' => 'OIC',
                'activo' => true,
            ],
        ];

        DB::table('puestos')->insert($puestos);
    }
}