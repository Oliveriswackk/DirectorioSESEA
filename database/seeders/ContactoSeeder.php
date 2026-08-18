<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactoSeeder extends Seeder
{
    public function run(): void
    {
        $contactos = [
            [
                'id' => 1,
                'nombre' => 'Juan',
                'apellido_paterno' => 'Pérez',
                'apellido_materno' => 'García',
                'activo' => true,
            ],
            [
                'id' => 2,
                'nombre' => 'María',
                'apellido_paterno' => 'Gómez',
                'apellido_materno' => 'López',
                'activo' => true,
            ],
            [
                'id' => 3,
                'nombre' => 'Carlos',
                'apellido_paterno' => 'Ruiz',
                'apellido_materno' => 'Martínez',
                'activo' => true,
            ],
            [
                'id' => 4,
                'nombre' => 'Ana',
                'apellido_paterno' => 'López',
                'apellido_materno' => 'Hernández',
                'activo' => true,
            ],
            [
                'id' => 5,
                'nombre' => 'Pedro',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Ramírez',
                'activo' => true,
            ],
            [
                'id' => 6,
                'nombre' => 'Soporte',
                'apellido_paterno' => 'Técnico',
                'apellido_materno' => null,
                'activo' => true,
            ],
            [
                'id' => 7,
                'nombre' => 'Luis',
                'apellido_paterno' => 'Torres',
                'apellido_materno' => 'Flores',
                'activo' => true,
            ],
            [
                'id' => 8,
                'nombre' => 'Sofía',
                'apellido_paterno' => 'Ramírez',
                'apellido_materno' => 'Cruz',
                'activo' => true,
            ],
            [
                'id' => 9,
                'nombre' => 'Roberto',
                'apellido_paterno' => 'Dávila',
                'apellido_materno' => 'Soto',
                'activo' => true,
            ],
            [
                'id' => 10,
                'nombre' => 'Personal',
                'apellido_paterno' => 'Operativo',
                'apellido_materno' => null,
                'activo' => true,
            ],
        ];

        foreach ($contactos as $contacto) {
            DB::table('contactos')->updateOrInsert(
                ['id' => $contacto['id']],
                $contacto
            );
        }
    }
}