<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignacionSeeder extends Seeder
{
    public function run(): void
    {
        $asignaciones = [
            [
                'id' => 1,
                'contacto_id' => 1,
                'ente_id' => 2, // Secretaría de Hacienda (Estatal / Nivel 1)
                'sede_id' => 11,
                'puesto_id' => 5, // Directivo / Mando Medio
                'correo' => 'juan.perez@chihuahua.gob.mx',
                'telefono' => '6141234567',
                'extension' => '101',
                'celular' => '6149876543',
                'fecha_inicio' => '2025-01-01',
                'fecha_fin' => null,
                'observaciones' => 'Asignación activa en Tesorería Estatal (Nivel 1).',
                'activo' => true,
            ],
            [
                'id' => 2,
                'contacto_id' => 2,
                'ente_id' => 12, // Secretaría de Seguridad Pública (Estatal / Nivel 1)
                'sede_id' => null,
                'puesto_id' => 8, // Operativo / Técnico especializado
                'correo' => 'maria.gomez@chihuahua.gob.mx',
                'telefono' => '6147654321',
                'extension' => '205',
                'celular' => null,
                'fecha_inicio' => '2025-02-15',
                'fecha_fin' => null,
                'observaciones' => 'Personal operativo estatal sin sede fija.',
                'activo' => true,
            ],
            [
                'id' => 3,
                'contacto_id' => 3,
                'ente_id' => 152, // Municipio de Chihuahua (Municipal / Nivel 3)
                'sede_id' => null,
                'puesto_id' => 4, // Coordinador de Área
                'correo' => 'carlos.ruiz@chihuahua.gob.mx',
                'telefono' => null,
                'extension' => null,
                'celular' => '6141112233',
                'fecha_inicio' => '2025-03-01',
                'fecha_fin' => null,
                'observaciones' => 'Asignación en Ayuntamiento de Chihuahua (Nivel 3).',
                'activo' => true,
            ],
            [
                'id' => 4,
                'contacto_id' => 4,
                'ente_id' => 15, // Secretaría de Cultura (Estatal / Nivel 1)
                'sede_id' => 126,
                'puesto_id' => 3, // Enlace Administrativo
                'correo' => null,
                'telefono' => '6149998877',
                'extension' => '300',
                'celular' => null,
                'fecha_inicio' => '2025-04-10',
                'fecha_fin' => null,
                'observaciones' => 'Enlace administrativo con sede asignada.',
                'activo' => true,
            ],
            [
                'id' => 5,
                'contacto_id' => 5,
                'ente_id' => 102, // JMAS Ahumada (Municipal / Nivel 3)
                'sede_id' => 11,
                'puesto_id' => 6, // Analista / Especialista
                'correo' => 'ana.lopez@jmasahumada.gob.mx',
                'telefono' => null,
                'extension' => null,
                'celular' => null,
                'fecha_inicio' => '2025-05-01',
                'fecha_fin' => null,
                'observaciones' => 'Paramunicipal del agua (Nivel 3) con datos mínimos.',
                'activo' => true,
            ],
            [
                'id' => 6,
                'contacto_id' => 6,
                'ente_id' => 101, // SESEA - Secretaría Ejecutiva Sistema Estatal Anticorrupción (Órgano Autónomo / Nivel 1)
                'sede_id' => 1,
                'puesto_id' => 10, // Consultor / Asesor Técnico
                'correo' => 'soporte.sesea@chihuahua.gob.mx',
                'telefono' => '6145554433',
                'extension' => '404',
                'celular' => '6144443322',
                'fecha_inicio' => '2025-06-01',
                'fecha_fin' => null,
                'observaciones' => 'Asignación en Órgano Autónomo Estatal.',
                'activo' => true,
            ],
            [
                'id' => 7,
                'contacto_id' => 7,
                'ente_id' => 170, // Municipio de Juárez (Municipal / Nivel 3)
                'sede_id' => null,
                'puesto_id' => 1, // Titular / Secretario / Alcalde
                'correo' => 'luis.torres@juarez.gob.mx',
                'telefono' => '6561112233',
                'extension' => null,
                'celular' => null,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2025-12-31',
                'observaciones' => 'Asignación histórica/inactiva en gobierno municipal fronterizo.',
                'activo' => true,
            ],
            [
                'id' => 8,
                'contacto_id' => 8,
                'ente_id' => 250, // FODARCH (Entidad Estatal / Nivel 1)
                'sede_id' => 19,
                'puesto_id' => 7, // Auxiliar de Servicios / Apoyo
                'correo' => 'sofia.ramirez@chihuahua.gob.mx',
                'telefono' => '6142223344',
                'extension' => '110',
                'celular' => '6145556677',
                'fecha_inicio' => '2025-01-15',
                'fecha_fin' => '2025-08-01',
                'observaciones' => 'Asignación concluída en entidad de fomento estatal.',
                'activo' => false,
            ],
            [
                'id' => 9,
                'contacto_id' => 9,
                'ente_id' => 201, // IMPLAN Chihuahua (Paramunicipal / Nivel 3)
                'sede_id' => 125,
                'puesto_id' => 11, // Investigador / Planeación
                'correo' => 'roberto.davila@chihuahua.gob.mx',
                'telefono' => '6143334455',
                'extension' => '112',
                'celular' => null,
                'fecha_inicio' => '2025-02-01',
                'fecha_fin' => null,
                'observaciones' => 'Personal técnico en organismo descentralizado municipal.',
                'activo' => true,
            ],
            [
                'id' => 10,
                'contacto_id' => 10,
                'ente_id' => 150, // Municipio de Cuauhtémoc (Municipal / Nivel 3)
                'sede_id' => null,
                'puesto_id' => 2, // Director General / Subsecretario
                'correo' => 'operativo.cuauhtemoc@chihuahua.gob.mx',
                'telefono' => '6254445566',
                'extension' => null,
                'celular' => '6251234567',
                'fecha_inicio' => '2025-07-01',
                'fecha_fin' => null,
                'observaciones' => 'Mando superior en administración municipal de la región menonita/centro.',
                'activo' => true,
            ],
        ];

        foreach ($asignaciones as $asignacion) {
            DB::table('asignaciones')->updateOrInsert(
                ['id' => $asignacion['id']],
                $asignacion
            );
        }
    }
}
