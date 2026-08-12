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
                ->with([
                    'contacto',
                    'ente.nivelGobierno',
                    'ente.municipio.estado',
                    'sede',
                    'puesto',
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