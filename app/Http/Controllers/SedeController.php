<?php

namespace App\Http\Controllers;

use App\Models\Ente;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    // Obtiene las sedes de un ente en JSON para el modal
    public function byEnte(Ente $ente)
    {
        return response()->json([
            'ente_nombre' => $ente->nombre,
            'sedes' => $ente->sedes
        ]);
    }

    //  Una nueva sede en AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ente_id' => 'required|exists:entes,id',
            'nombre' => 'required|string|max:255',
            'direccion_texto' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo') ? $request->activo : true;

        $sede = Sede::create($validated);

        return response()->json([
            'success' => true,
            'sede' => $sede,
            'message' => 'Sede agregada correctamente.'
        ]);
    }

    // Cambia el estado de una sede
    public function toggleStatus(Sede $sede)
    {
        $sede->update(['activo' => !$sede->activo]);

        return response()->json([
            'success' => true,
            'activo' => $sede->activo
        ]);
    }
}