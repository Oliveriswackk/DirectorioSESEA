<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoApiController extends Controller
{
    public function buscar(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $contactos = Contacto::query()
            ->where('activo', true)
            ->where(function ($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%")
                    ->orWhere('apellido_paterno', 'like', "%{$q}%")
                    ->orWhere('apellido_materno', 'like', "%{$q}%");
            })
            ->with([
                'asignaciones' => function ($query) {
                    $query->where('activo', true)
                        ->with(['puesto', 'ente']);
                }
            ])
            ->limit(10)
            ->get();

        $resultados = $contactos->map(function ($contacto) {

            $asignacion = $contacto->asignaciones->first();

            return [
                'id' => $contacto->id,
                'nombre' => trim(implode(' ', array_filter([
                    $contacto->nombre,
                    $contacto->apellido_paterno,
                    $contacto->apellido_materno,
                ]))),
                'cargo' => $asignacion?->puesto?->nombre,
                'dependencia' => $asignacion?->ente?->nombre,
            ];
        });

        return response()->json($resultados->values());
    }
}