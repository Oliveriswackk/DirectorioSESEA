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