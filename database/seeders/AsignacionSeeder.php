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
        
        // Obtenemos IDs disponibles o usamos 1 por defecto si las tablas están vacías
        $entesIds = Ente::pluck('id')->toArray();
        $sedesIds = Sede::pluck('id')->toArray();
        $puestosIds = Puesto::pluck('id')->toArray();

        $entesIds = empty($entesIds) ? [1] : $entesIds;
        $sedesIds = empty($sedesIds) ? [1] : $sedesIds;
        $puestosIds = empty($puestosIds) ? [1] : $puestosIds;

        $i = 0;
        foreach ($contactos as $contacto) {
            // Distribuir de forma cíclica usando el índice
            $enteId = $entesIds[$i % count($entesIds)];
            $sedeId = $sedesIds[$i % count($sedesIds)];
            $puestoId = $puestosIds[$i % count($puestosIds)];

            Asignacion::create([
                'contacto_id' => $contacto->id,
                'ente_id' => $enteId,
                'sede_id' => $sedeId,
                'puesto_id' => $puestoId,
                'correo' => 'contacto.prueba' . ($i + 1) . '@ejemplo.gob.mx',
                'telefono' => '61455500' . sprintf('%02d', $i),
                'extension' => (string)(1000 + $i),
                'celular' => '61444400' . sprintf('%02d', $i),
                'fecha_inicio' => '2025-01-15',
                'fecha_fin' => null,
                'observaciones' => 'Asignación de prueba generada automáticamente.',
                'activo' => true,
            ]);

            $i++;
        }
    }
}