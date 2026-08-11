<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asignacion;
use App\Models\Contacto;
use App\Models\Ente;
use App\Models\Sede;
use App\Models\Puesto;

class AsignacionSeeder extends Seeder
{
    public function run(): void
    {
        $contactos = Contacto::all();
        
        $entesIds = Ente::pluck('id')->toArray();
        $sedesIds = Sede::pluck('id')->toArray();
        $puestosIds = Puesto::pluck('id')->toArray();

        // Asegurarnos de tener respaldos si las tablas estuvieran vacías
        $entesIds = empty($entesIds) ? [1] : $entesIds;
        $sedesIds = empty($sedesIds) ? [1] : $sedesIds;
        $puestosIds = empty($puestosIds) ? [1] : $puestosIds;

        foreach ($contactos as $index => $contacto) {
            // Escenario 1: Alternar ente de forma única para que no se repitan siempre los mismos
            $enteId = $entesIds[$index % count($entesIds)];
            
            // Escenario 2: Algunos contactos sin sede (null) para probar validaciones
            $sedeId = ($index % 4 === 0) ? null : $sedesIds[$index % count($sedesIds)];
            
            // Escenario 3: Variedad de puestos
            $puestoId = $puestosIds[$index % count($puestosIds)];

            // Escenario 4: Algunos sin correo electrónico oficial
            $correo = ($index % 5 === 0) ? null : 'contacto.' . ($index + 1) . '@chihuahua.gob.mx';

            // Escenario 5: Un par de contactos inactivos (activo => false) para probar el filtro de inactivos
            $activo = ($index == 6 || $index == 14) ? false : true;

            Asignacion::create([
                'contacto_id' => $contacto->id,
                'ente_id' => $enteId,
                'sede_id' => $sedeId,
                'puesto_id' => $puestoId,
                'correo' => $correo,
                'telefono' => '61455500' . sprintf('%02d', $index),
                'extension' => (string)(1000 + $index),
                'celular' => ($index % 2 == 0) ? '61444400' . sprintf('%02d', $index) : null,
                'fecha_inicio' => '2025-01-15',
                'fecha_fin' => $activo ? null : '2026-01-01',
                'observaciones' => 'Escenario de prueba #' . ($index + 1) . ' generado automáticamente.',
                'activo' => $activo,
            ]);
        }
    }
}