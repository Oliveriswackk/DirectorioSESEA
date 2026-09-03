<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'nombre' => 'Administrador',
                'activo' => 1,
            ],
            [
                'id' => 2,
                'nombre' => 'Coordinador',
                'activo' => 1,
            ],
            [
                'id' => 3,
                'nombre' => 'Colaborador',
                'activo' => 1,
            ],
            [
                'id' => 4,
                'nombre' => 'Invitado',
                'activo' => 1,
            ],
        ]);
    }
}
