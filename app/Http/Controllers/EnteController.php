<?php

namespace App\Http\Controllers;

use App\Models\Ente;
use App\Models\NivelGobierno;
use App\Models\Municipio;
use App\Services\BitacoraService;
use Illuminate\Http\Request;

class EnteController extends Controller
{
    public function __construct(
        private BitacoraService $bitacora
    ) {
    }

    public function index()
    {
        // Carga optimizada con relaciones específicas y el conteo de sedes
        $entes = Ente::with(['nivelGobierno:id,nombre', 'municipio.estado:id,nombre'])
            ->withCount('sedes')
            ->get();

        $nivelesGobierno = NivelGobierno::where('activo', true)
            ->select('id', 'nombre')
            ->get();

        $municipios = Municipio::where('activo', true)
            ->select('id', 'nombre', 'estado_id')
            ->with('estado:id,nombre')
            ->get();

        return view('entes.index', compact(
            'entes',
            'nivelesGobierno',
            'municipios'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'siglas' => 'nullable|string|max:20',
            'nivel_gobierno_id' => 'required|exists:niveles_gobierno,id',
            'municipio_id' => 'nullable|exists:municipios,id',
        ]);

        $ente = Ente::create($validated + [
            'activo' => true,
        ]);

        $this->bitacora->registrar(
            'Ente',
            $ente->id,
            'registro_ente',
            'Se registró un nuevo ente en el Directorio.'
        );

        return redirect()
            ->route('entes.index')
            ->with('success', 'Ente registrado correctamente.');
    }

    public function update(Request $request, Ente $ente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'siglas' => 'nullable|string|max:20',
            'nivel_gobierno_id' => 'required|exists:niveles_gobierno,id',
            'municipio_id' => 'nullable|exists:municipios,id',
        ]);

        $ente->update($validated);

        $this->bitacora->registrar(
            'Ente',
            $ente->id,
            'modificacion_ente',
            'Se modificó la información del ente.'
        );

        return redirect()
            ->route('entes.index')
            ->with('success', 'Ente actualizado correctamente.');
    }

    public function toggle(Ente $ente)
    {
        $ente->update([
            'activo' => !$ente->activo,
        ]);

        $estado = $ente->activo ? 'activó' : 'desactivó';

        $this->bitacora->registrar(
            'Ente',
            $ente->id,
            'cambio_estado_ente',
            "Se {$estado} el ente."
        );

        return redirect()
            ->route('entes.index')
            ->with('success', 'Estatus actualizado con éxito.');
    }
}