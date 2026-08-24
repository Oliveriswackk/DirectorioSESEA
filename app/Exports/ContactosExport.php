<?php

namespace App\Exports;

use App\Models\Asignacion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContactosExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected ?string $busqueda;
    protected ?string $nivelGobierno;
    protected ?string $ente;
    protected ?string $puesto;
    protected ?string $revision;

    public function __construct(
        ?string $busqueda = null,
        ?string $nivelGobierno = null,
        ?string $ente = null,
        ?string $puesto = null,
        ?string $revision = null
    ) {
        $this->busqueda = $busqueda;
        $this->nivelGobierno = $nivelGobierno;
        $this->ente = $ente;
        $this->puesto = $puesto;
        $this->revision = $revision;
    }


    public function collection(): Collection
    {
        $query = Asignacion::with([
            'contacto',
            'puesto',
            'ente.nivelGobierno',
            'sede',
        ])
            ->where('activo', true);


        // NIVEL DE GOBIERNO
        if (!empty($this->nivelGobierno)) {

            $query->whereHas('ente', function ($q) {

                $q->where(
                    'nivel_gobierno_id',
                    $this->nivelGobierno
                );

            });
        }


        // =====================================================
        // ENTE
        // =====================================================

        if (!empty($this->ente)) {

            $query->where(
                'ente_id',
                $this->ente
            );
        }


        // =====================================================
        // PUESTO
        // =====================================================

        if (!empty($this->puesto)) {

            $query->where(
                'puesto_id',
                $this->puesto
            );
        }


        // =====================================================
        // REVISIÓN
        // =====================================================

        if ($this->revision === 'requiere_revision') {

            $fechaLimite = now()->subMonths(3);

            $query->where(
                'updated_at',
                '<=',
                $fechaLimite
            );
        }


        // =====================================================
        // BÚSQUEDA GLOBAL
        // =====================================================

        if (!empty($this->busqueda)) {

            $busqueda = trim($this->busqueda);

            $query->where(function ($q) use ($busqueda) {

                $q->whereHas('contacto', function ($contacto) use ($busqueda) {

                    $contacto->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('apellido_paterno', 'like', "%{$busqueda}%")
                        ->orWhere('apellido_materno', 'like', "%{$busqueda}%");

                })
                ->orWhereHas('puesto', function ($puesto) use ($busqueda) {

                    $puesto->where(
                        'nombre',
                        'like',
                        "%{$busqueda}%"
                    );

                })
                ->orWhereHas('ente', function ($ente) use ($busqueda) {

                    $ente->where(
                        'nombre',
                        'like',
                        "%{$busqueda}%"
                    );

                })
                ->orWhereHas('sede', function ($sede) use ($busqueda) {

                    $sede->where(
                        'nombre',
                        'like',
                        "%{$busqueda}%"
                    );

                })
                ->orWhere('correo', 'like', "%{$busqueda}%")
                ->orWhere('telefono', 'like', "%{$busqueda}%")
                ->orWhere('celular', 'like', "%{$busqueda}%")
                ->orWhere('extension', 'like', "%{$busqueda}%")
                ->orWhere('observaciones', 'like', "%{$busqueda}%");

            });
        }


        return $query
            ->orderBy('id')
            ->get();
    }


    public function headings(): array
    {
        return [
            'Nombre',
            'Puesto',
            'Ente',
            'Correo',
            'Teléfono',
            'Celular',
            'Extensión',
            'Última actualización',
        ];
    }


    public function map($asignacion): array
    {
        $contacto = $asignacion->contacto;

        return [
            trim(
                $contacto->nombre . ' ' .
                ($contacto->apellido_paterno ?? '') . ' ' .
                ($contacto->apellido_materno ?? '')
            ),

            $asignacion->puesto->nombre ?? '',

            $asignacion->ente->nombre ?? '',

            $asignacion->correo ?? '',

            $asignacion->telefono ?? '',

            $asignacion->celular ?? '',

            $asignacion->extension ?? '',

            optional($asignacion->updated_at)
                ->format('d/m/Y H:i'),
        ];
    }


    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}