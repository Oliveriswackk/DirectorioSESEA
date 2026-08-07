<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\Ente;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function index(Request $request)
    {
        $ente_id = $request->get('ente_id');
        $search = $request->get('search');

        // Consulta optimizada con carga ambiciosa de la relación ente
        $sedes = Sede::with('ente:id,nombre,siglas')
            ->when($ente_id, function ($query, $ente_id) {
                return $query->where('ente_id', $ente_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('direccion_texto', 'like', "%{$search}%")
                      ->orWhereHas('ente', function ($qEnte) use ($search) {
                          $qEnte->where('nombre', 'like', "%{$search}%")
                                ->orWhere('siglas', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Traemos entes para los select de los modales y filtros
        $entes = Ente::where('activo', true)->select('id', 'nombre', 'siglas')->orderBy('nombre', 'asc')->get();

        return view('sedes.index', compact('sedes', 'entes', 'ente_id', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ente_id' => 'required|exists:entes,id',
            'nombre' => 'required|string|max:255',
            'direccion_texto' => 'nullable|string|max:500',
        ]);

        Sede::create($validated + ['activo' => true]);

        return redirect()->route('sedes.index')->with('success', 'Sede registrada correctamente.');
    }

    public function update(Request $request, Sede $sede)
    {
        $validated = $request->validate([
            'ente_id' => 'required|exists:entes,id',
            'nombre' => 'required|string|max:255',
            'direccion_texto' => 'nullable|string|max:500',
        ]);

        $sede->update($validated);

        return redirect()->route('sedes.index')->with('success', 'Sede actualizada correctamente.');
    }

    public function toggle(Sede $sede)
    {
        $sede->update(['activo' => !$sede->activo]);

        return redirect()->route('sedes.index')->with('success', 'Estatus de sede actualizado.');
    }
}