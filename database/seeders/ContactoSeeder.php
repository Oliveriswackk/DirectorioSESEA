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

            // Nuevos contactos
            [
                'id' => 11,
                'nombre' => 'Laura',
                'apellido_paterno' => 'Mendoza',
                'apellido_materno' => 'Castillo',
                'activo' => true,
            ],
            [
                'id' => 12,
                'nombre' => 'Jorge',
                'apellido_paterno' => 'Navarro',
                'apellido_materno' => 'Vega',
                'activo' => true,
            ],
            [
                'id' => 13,
                'nombre' => 'Daniela',
                'apellido_paterno' => 'Morales',
                'apellido_materno' => 'Ríos',
                'activo' => true,
            ],
            [
                'id' => 14,
                'nombre' => 'Miguel',
                'apellido_paterno' => 'Ortega',
                'apellido_materno' => 'Salazar',
                'activo' => true,
            ],
            [
                'id' => 15,
                'nombre' => 'Fernanda',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'Núñez',
                'activo' => true,
            ],
            [
                'id' => 16,
                'nombre' => 'Ricardo',
                'apellido_paterno' => 'Cervantes',
                'apellido_materno' => 'Mejía',
                'activo' => true,
            ],
            [
                'id' => 17,
                'nombre' => 'Patricia',
                'apellido_paterno' => 'Valdez',
                'apellido_materno' => 'Campos',
                'activo' => true,
            ],
            [
                'id' => 18,
                'nombre' => 'Andrés',
                'apellido_paterno' => 'Fuentes',
                'apellido_materno' => 'Rangel',
                'activo' => true,
            ],
            [
                'id' => 19,
                'nombre' => 'Gabriela',
                'apellido_paterno' => 'Pineda',
                'apellido_materno' => 'Acosta',
                'activo' => true,
            ],
            [
                'id' => 20,
                'nombre' => 'Eduardo',
                'apellido_paterno' => 'Márquez',
                'apellido_materno' => 'León',
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