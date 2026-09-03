<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelGobiernoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('niveles_gobierno')->insert([
            ['id' => 1, 'nombre' => 'Federal', 'activo' => 1],
            ['id' => 2, 'nombre' => 'Estatal', 'activo' => 1],
            ['id' => 3, 'nombre' => 'Municipal', 'activo' => 1],
        ]);
    }
}
