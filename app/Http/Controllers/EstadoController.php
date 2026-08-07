<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index()
    {
        // Traemos todos los estados ordenados para que DataTables filtre y pagine en tiempo real en el cliente
        $estados = Estado::orderBy('nombre', 'asc')->get();

        return view('estados.index', compact('estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:estados,nombre',
        ]);

        Estado::create([
            'nombre' => $validated['nombre'],
            'activo' => true,
        ]);

        return redirect()->route('estados.index')->with('success', 'Estado registrado correctamente.');
    }

    public function update(Request $request, Estado $estado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:estados,nombre,' . $estado->id,
        ]);

        $estado->update([
            'nombre' => $validated['nombre'],
        ]);

        return redirect()->route('estados.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function toggleActive(Estado $estado)
    {
        $estado->update([
            'activo' => !$estado->activo,
        ]);

        return redirect()->route('estados.index')->with('success', 'Estatus actualizado.');
    }
}