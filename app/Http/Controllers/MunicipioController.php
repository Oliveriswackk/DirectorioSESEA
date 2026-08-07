<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        // Buscar el ID de Chihuahua por defecto
        $chihuahua = Estado::where('nombre', 'LIKE', '%Chihuahua%')->first();
        $defaultEstadoId = $chihuahua ? $chihuahua->id : null;

        // Si el usuario no mandó un estado ni búsqueda, asignamos Chihuahua por defecto
        $estado_id = $request->input('estado_id', $defaultEstadoId);
        $search = $request->input('search');

        // Catálogo de estados activos para el select
        $estados = Estado::where('activo', true)->orderBy('nombre', 'asc')->get();

        // Consulta filtrada y súper ligera (solo 15 registros por página)
        $municipios = Municipio::with('estado')
            ->when($estado_id, function ($query, $estado_id) {
                return $query->where('estado_id', $estado_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'LIKE', "%{$search}%");
            })
            ->orderBy('nombre', 'asc')
            ->paginate(15)
            ->appends($request->all());

        return view('municipios.index', compact('municipios', 'estados', 'search', 'estado_id'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'estado_id' => 'required|exists:estados,id',
            'nombre'    => 'required|string|max:100',
        ]);

        Municipio::create([
            'estado_id' => $validated['estado_id'],
            'nombre'    => $validated['nombre'],
            'activo'    => true,
        ]);

        return redirect()->route('municipios.index')->with('success', 'Municipio registrado correctamente.');
    }


    public function update(Request $request, Municipio $municipio)
    {
        $validated = $request->validate([
            'estado_id' => 'required|exists:estados,id',
            'nombre'    => 'required|string|max:100',
        ]);

        $municipio->update($validated);

        return redirect()->route('municipios.index')->with('success', 'Municipio actualizado correctamente.');
    }

    
    public function toggleActive(Municipio $municipio)
    {
        $municipio->update([
            'activo' => !$municipio->activo,
        ]);

        return redirect()->back()->with('success', 'Estatus actualizado.');
    }
}