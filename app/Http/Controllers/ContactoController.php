<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Contacto;
use App\Models\Puesto;
use App\Models\Ente;
use App\Models\Sede;
use App\Models\NivelGobierno;
use App\Queries\AsignacionQuery;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::with([
            'contacto',
            'puesto',
            'ente.nivelGobierno',
            'sede',
        ])->get();

        $puestos = Puesto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $entes = Ente::where('activo', true)
            ->with('nivelGobierno')
            ->orderBy('nombre')
            ->get();

        $nivelesGobierno = NivelGobierno::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $sedes = Sede::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('contactos.index', compact(
            'asignaciones',
            'puestos',
            'entes',
            'sedes',
            'nivelesGobierno'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'extension' => 'nullable|string|max:20',
            'puesto_id' => 'required|exists:puestos,id',
            'ente_id' => 'required|exists:entes,id',
            'sede_id' => 'nullable|exists:sedes,id',
        ]);

        // 1. Creamos o guardamos el contacto base
        $contacto = Contacto::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
        ]);

        // 2. Creamos su asignación asociada con los datos de contacto específicos de ese puesto/ente
        Asignacion::create([
            'contacto_id' => $contacto->id,
            'puesto_id' => $request->puesto_id,
            'ente_id' => $request->ente_id,
            'sede_id' => $request->sede_id,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'extension' => $request->extension,
        ]);

        return redirect()->route('contactos.index')->with('success', 'Contacto registrado exitosamente.');
    }


    public function update(Request $request, $id)
    {
        // El $id que llega aquí desde el botón editar es el contacto_id
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'extension' => 'nullable|string|max:20',
            'puesto_id' => 'required|exists:puestos,id',
            'ente_id' => 'required|exists:entes,id',
            'sede_id' => 'nullable|exists:sedes,id',
        ]);

        // 1. Actualizamos los datos generales del contacto
        $contacto = Contacto::findOrFail($id);
        $contacto->update([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
        ]);

        // 2. Actualizamos o buscamos su asignación vinculada
        $asignacion = Asignacion::where('contacto_id', $contacto->id)->first();
        
        if ($asignacion) {
            $asignacion->update([
                'puesto_id' => $request->puesto_id,
                'ente_id' => $request->ente_id,
                'sede_id' => $request->sede_id,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'extension' => $request->extension,
            ]);
        } else {
            // Si por algo no tuviera asignación previa, la creamos
            Asignacion::create([
                'contacto_id' => $contacto->id,
                'puesto_id' => $request->puesto_id,
                'ente_id' => $request->ente_id,
                'sede_id' => $request->sede_id,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'extension' => $request->extension,
            ]);
        }

        return redirect()->route('contactos.index')->with('success', 'Contacto actualizado exitosamente.');
    }


    public function updateNota(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'nullable|string',
        ]);

        // El ID de las notas corresponde al contacto (observaciones está en la tabla contactos)
        $contacto = Contacto::findOrFail($id);
        $contacto->update([
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('contactos.index')->with('success', 'Nota guardada exitosamente.');
    }
}