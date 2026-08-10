<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contacto;

class ContactoSeeder extends Seeder
{
    public function run(): void
    {
        $contactos = [
            ['nombre' => 'Juan Carlos', 'apellido_paterno' => 'Pérez', 'apellido_materno' => 'Gómez', 'observaciones' => 'Contacto principal de área técnica.'],
            ['nombre' => 'María Fernanda', 'apellido_paterno' => 'López', 'apellido_materno' => 'Martínez', 'observaciones' => 'Enlace institucional para auditorías.'],
            ['nombre' => 'Roberto', 'apellido_paterno' => 'Ramírez', 'apellido_materno' => 'Hernández', 'observaciones' => 'Soporte de infraestructura de redes.'],
            ['nombre' => 'Ana Sofía', 'apellido_paterno' => 'Torres', 'apellido_materno' => 'Jiménez', 'observaciones' => 'Coordinación de proyectos especiales.'],
            ['nombre' => 'Luis Alberto', 'apellido_paterno' => 'Flores', 'apellido_materno' => 'Morales', 'observaciones' => 'Desarrollador backend senior.'],
            ['nombre' => 'Carmen Rosa', 'apellido_paterno' => 'Vargas', 'apellido_materno' => 'Castillo', 'observaciones' => 'Gestión documental y oficialía de partes.'],
            ['nombre' => 'José Antonio', 'apellido_paterno' => 'Rojas', 'apellido_materno' => 'Ortiz', 'observaciones' => 'Jefatura de departamento jurídico.'],
            ['nombre' => 'Guadalupe', 'apellido_paterno' => 'Mendoza', 'apellido_materno' => 'Silva', 'observaciones' => 'Analista de presupuestos y finanzas.'],
            ['nombre' => 'Francisco Javier', 'apellido_paterno' => 'Castillo', 'apellido_materno' => 'Guerrero', 'observaciones' => 'Enlace de transparencia y acceso a la información.'],
            ['nombre' => 'Daniela', 'apellido_paterno' => 'Navarro', 'apellido_materno' => 'Ríos', 'observaciones' => ''],
            ['nombre' => 'Alejandro', 'apellido_paterno' => 'Medina', 'apellido_materno' => 'Vega', 'observaciones' => ''],
            ['nombre' => 'Patricia', 'apellido_paterno' => 'Soto', 'apellido_materno' => 'Estrada', 'observaciones' => 'Coordinadora de recursos humanos.'],
            ['nombre' => 'Manuel', 'apellido_paterno' => 'Contreras', 'apellido_materno' => 'Pacheco', 'observaciones' => 'Soporte técnico en sitio.'],
            ['nombre' => 'Rosa María', 'apellido_paterno' => 'Santos', 'apellido_materno' => 'Aguilar', 'observaciones' => 'Secretaría de dirección general.'],
            ['nombre' => 'Jorge Luis', 'apellido_paterno' => 'Domínguez', 'apellido_materno' => 'Salazar', 'observaciones' => 'Auditor interno de procesos.'],
            ['nombre' => 'Valeria', 'apellido_paterno' => 'Guzmán', 'apellido_materno' => 'Cervantes', 'observaciones' => 'Analista de datos y estadística.'],
            ['nombre' => 'Ricardo', 'apellido_paterno' => 'Luna', 'apellido_materno' => 'Peña', 'observaciones' => 'Especialista en ciberseguridad.'],
            ['nombre' => 'Adriana', 'apellido_paterno' => 'Reyes', 'apellido_materno' => 'Mejía', 'observaciones' => 'Responsable de comunicación social.'],
            ['nombre' => 'Héctor', 'apellido_paterno' => 'Cruz', 'apellido_materno' => 'Duarte', 'observaciones' => 'Jefe de unidad de informática.'],
            ['nombre' => 'Gabriela', 'apellido_paterno' => 'Herrera', 'apellido_materno' => 'Sánchez', 'observaciones' => 'Gestora de trámites interinstitucionales.'],
        ];

        foreach ($contactos as $contacto) {
            Contacto::create([
                'nombre' => $contacto['nombre'],
                'apellido_paterno' => $contacto['apellido_paterno'],
                'apellido_materno' => $contacto['apellido_materno'],
                'observaciones' => $contacto['observaciones'],
                'activo' => true,
            ]);
        }
    }
}