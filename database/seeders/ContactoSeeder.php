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
                'observaciones' => 'Contacto principal de Hacienda.',
                'activo' => true,
            ],
            [
                'id' => 2,
                'nombre' => 'María',
                'apellido_paterno' => 'Gómez',
                'apellido_materno' => 'López',
                'observaciones' => 'Enlace asignado a seguridad.',
                'activo' => true,
            ],
            [
                'id' => 3,
                'nombre' => 'Carlos',
                'apellido_paterno' => 'Ruiz',
                'apellido_materno' => 'Martínez',
                'observaciones' => null,
                'activo' => true,
            ],
            [
                'id' => 4,
                'nombre' => 'Ana',
                'apellido_paterno' => 'López',
                'apellido_materno' => 'Hernández',
                'observaciones' => 'Comisión temporal.',
                'activo' => true,
            ],
            [
                'id' => 5,
                'nombre' => 'Pedro',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Ramírez',
                'observaciones' => null,
                'activo' => true,
            ],
            [
                'id' => 6,
                'nombre' => 'Soporte',
                'apellido_paterno' => 'Técnico',
                'apellido_materno' => null,
                'observaciones' => 'Área de soporte general.',
                'activo' => true,
            ],
            [
                'id' => 7,
                'nombre' => 'Luis',
                'apellido_paterno' => 'Torres',
                'apellido_materno' => 'Flores',
                'observaciones' => 'Baja temporal.',
                'activo' => false,
            ],
            [
                'id' => 8,
                'nombre' => 'Sofía',
                'apellido_paterno' => 'Ramírez',
                'apellido_materno' => 'Cruz',
                'observaciones' => null,
                'activo' => true,
            ],
            [
                'id' => 9,
                'nombre' => 'Roberto',
                'apellido_paterno' => 'Dávila',
                'apellido_materno' => 'Soto',
                'observaciones' => null,
                'activo' => true,
            ],
            [
                'id' => 10,
                'nombre' => 'Personal',
                'apellido_paterno' => 'Operativo',
                'apellido_materno' => null,
                'observaciones' => 'Registro genérico operativo.',
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