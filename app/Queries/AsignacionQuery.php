<?php

namespace App\Queries;

use App\Models\Asignacion;
use Illuminate\Database\Eloquent\Builder;

class AsignacionQuery
{
    public function __construct(
        protected Builder $query
    ) {
    }


    public static function make(): self
    {
        return new self(
            Asignacion::query()
                ->select([
                    'id',
                    'contacto_id',
                    'ente_id',
                    'sede_id',
                    'puesto_id',
                    'correo',
                    'telefono',
                    'extension',
                    'celular',
                    'observaciones',
                    'activo',
                    'updated_at',
                ])
                ->with([
                    'contacto:id,nombre,apellido_paterno,apellido_materno',

                    'ente:id,nivel_gobierno_id,municipio_id,nombre,siglas',

                    'ente.nivelGobierno:id,nombre',

                    'ente.municipio' => function ($query) {
                        $query->select([
                            'id',
                            'estado_id',
                            'nombre',
                        ]);
                    },

                    'ente.municipio.estado' => function ($query) {
                        $query->select([
                            'id',
                            'nombre',
                        ]);
                    },

                    'sede:id,nombre,direccion_texto',

                    'puesto:id,nombre',
                ])
                ->where('activo', true)
        );
    }


    public function filter(array $filters): self
    {
        $this->query
            ->when($filters['nivel_gobierno'] ?? null, function ($query, $value) {
                $query->whereHas('ente', function ($query) use ($value) {
                    $query->where('nivel_gobierno_id', $value);
                });
            })

            ->when($filters['estado'] ?? null, function ($query, $value) {
                $query->whereHas('ente.municipio', function ($query) use ($value) {
                    $query->where('estado_id', $value);
                });
            })

            ->when($filters['municipio'] ?? null, function ($query, $value) {
                $query->whereHas('ente', function ($query) use ($value) {
                    $query->where('municipio_id', $value);
                });
            })

            ->when($filters['ente'] ?? null, function ($query, $value) {
                $query->where('ente_id', $value);
            })

            ->when($filters['sede'] ?? null, function ($query, $value) {
                $query->where('sede_id', $value);
            })

            ->when($filters['puesto'] ?? null, function ($query, $value) {
                $query->where('puesto_id', $value);
            })

            ->when($filters['revision'] ?? null, function ($query, $value) {
                $fechaLimite = now()->subMonths(3);

                if ($value === 'requiere_revision') {
                    $query->whereNotNull('updated_at')
                        ->where('updated_at', '<=', $fechaLimite);
                }

                if ($value === 'no_requiere_revision') {
                    $query->where(function ($query) use ($fechaLimite) {
                        $query->whereNull('updated_at')
                            ->orWhere('updated_at', '>', $fechaLimite);
                    });
                }
            })

            ->when($filters['busqueda'] ?? null, function ($query, $value) {
                $terminos = preg_split('/\s+/', trim($value));

                foreach ($terminos as $termino) {
                    $query->where(function ($query) use ($termino) {
                        $query
                            ->whereHas('contacto', function ($query) use ($termino) {
                                $query
                                    ->where('nombre', 'like', "%{$termino}%")
                                    ->orWhere('apellido_paterno', 'like', "%{$termino}%")
                                    ->orWhere('apellido_materno', 'like', "%{$termino}%");
                            })
                            ->orWhereHas('ente', function ($query) use ($termino) {
                                $query
                                    ->where('nombre', 'like', "%{$termino}%")
                                    ->orWhere('siglas', 'like', "%{$termino}%");
                            })
                            ->orWhereHas('puesto', function ($query) use ($termino) {
                                $query->where('nombre', 'like', "%{$termino}%");
                            })
                            ->orWhere('correo', 'like', "%{$termino}%")
                            ->orWhere('telefono', 'like', "%{$termino}%")
                            ->orWhere('celular', 'like', "%{$termino}%");
                    });
                }
            });

        return $this;
    }
    
    
    public function get()
    {
        return $this->query->get();
    }


    public function paginate(int $perPage = 25)
    {
        return $this->query->paginate($perPage);
    }
}