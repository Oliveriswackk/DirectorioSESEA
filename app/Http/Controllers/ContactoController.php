<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Contacto;
use App\Models\Puesto;
use App\Models\Ente;
use App\Models\Sede;
use App\Models\NivelGobierno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20|regex:/^[0-9\s\-\(\)]+$/',
            'celular' => 'nullable|string|max:20|regex:/^[0-9\s\-\(\)]+$/',
            'extension' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'puesto_id' => 'required|exists:puestos,id',
            'ente_id' => 'required|exists:entes,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'observaciones' => 'nullable|string|max:255',
        ]);

        if (
            empty($validated['correo']) &&
            empty($validated['telefono']) &&
            empty($validated['celular'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'correo' => 'Debe registrar al menos un medio de comunicación: correo, teléfono o celular.',
                ]);
        }

        $asignacionExistente = Asignacion::where('ente_id', $validated['ente_id'])
            ->where('puesto_id', $validated['puesto_id'])
            ->where('activo', true)
            ->first();

        if ($asignacionExistente) {
            return back()
                ->withInput()
                ->with('asignacion_existente', $asignacionExistente->id);
        }

        DB::transaction(function () use ($validated) {
            $contacto = Contacto::create([
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'activo' => true,
            ]);

            Asignacion::create([
                'contacto_id' => $contacto->id,
                'puesto_id' => $validated['puesto_id'],
                'ente_id' => $validated['ente_id'],
                'sede_id' => $validated['sede_id'] ?? null,
                'correo' => $validated['correo'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'celular' => $validated['celular'] ?? null,
                'extension' => $validated['extension'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => null,
                'activo' => true,
            ]);
        });

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20|regex:/^[0-9\s\-\(\)]+$/',
            'celular' => 'nullable|string|max:20|regex:/^[0-9\s\-\(\)]+$/',
            'extension' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'puesto_id' => 'required|exists:puestos,id',
            'ente_id' => 'required|exists:entes,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'observaciones' => 'nullable|string|max:255',
            'tipo_actualizacion' => 'nullable|in:correccion,cambio',
        ]);

        if (
            empty($validated['correo']) &&
            empty($validated['telefono']) &&
            empty($validated['celular'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'correo' => 'Debe registrar al menos un medio de comunicación: correo, teléfono o celular.',
                ]);
        }

        $contacto = Contacto::findOrFail($id);

        $asignacion = Asignacion::where('contacto_id', $contacto->id)
            ->where('activo', true)
            ->first();

        if (!$asignacion) {
            $asignacion = Asignacion::where('contacto_id', $contacto->id)
                ->latest('id')
                ->first();
        }

        if (!$asignacion) {
            return back()
                ->withErrors([
                    'contacto' => 'El contacto no tiene una asignación registrada.',
                ])
                ->withInput();
        }

        $cambioDeAsignacion =
            $asignacion->ente_id != $validated['ente_id'] ||
            $asignacion->puesto_id != $validated['puesto_id'];

        if ($cambioDeAsignacion && empty($validated['tipo_actualizacion'])) {
            return back()
                ->withInput()
                ->with('requiere_decision_actualizacion', true);
        }

        if ($cambioDeAsignacion && $validated['tipo_actualizacion'] === 'correccion') {
            $asignacionOcupada = Asignacion::where('ente_id', $validated['ente_id'])
                ->where('puesto_id', $validated['puesto_id'])
                ->where('activo', true)
                ->where('id', '!=', $asignacion->id)
                ->first();

            if ($asignacionOcupada) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'puesto_id' => 'Ya existe una asignación activa para este Ente y Puesto.',
                    ]);
            }
        }

        if ($cambioDeAsignacion && $validated['tipo_actualizacion'] === 'cambio') {
            $asignacionOcupada = Asignacion::where('ente_id', $validated['ente_id'])
                ->where('puesto_id', $validated['puesto_id'])
                ->where('activo', true)
                ->where('id', '!=', $asignacion->id)
                ->first();

            if ($asignacionOcupada) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'puesto_id' => 'Ya existe una asignación activa para este Ente y Puesto.',
                    ]);
            }

            DB::transaction(function () use ($validated, $contacto, $asignacion) {
                $contacto->update([
                    'nombre' => $validated['nombre'],
                    'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                    'apellido_materno' => $validated['apellido_materno'] ?? null,
                ]);

                $asignacion->update([
                    'fecha_fin' => now()->toDateString(),
                    'activo' => false,
                ]);

                Asignacion::create([
                    'contacto_id' => $contacto->id,
                    'puesto_id' => $validated['puesto_id'],
                    'ente_id' => $validated['ente_id'],
                    'sede_id' => $validated['sede_id'] ?? null,
                    'correo' => $validated['correo'] ?? null,
                    'telefono' => $validated['telefono'] ?? null,
                    'celular' => $validated['celular'] ?? null,
                    'extension' => $validated['extension'] ?? null,
                    'observaciones' => $validated['observaciones'] ?? null,
                    'fecha_inicio' => now()->toDateString(),
                    'fecha_fin' => null,
                    'activo' => true,
                ]);
            });

            return redirect()
                ->route('contactos.index')
                ->with('success', 'Cambio de asignación registrado exitosamente.');
        }

        DB::transaction(function () use ($validated, $contacto, $asignacion) {
            $contacto->update([
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                'apellido_materno' => $validated['apellido_materno'] ?? null,
            ]);

            $asignacion->update([
                'puesto_id' => $validated['puesto_id'],
                'ente_id' => $validated['ente_id'],
                'sede_id' => $validated['sede_id'] ?? null,
                'correo' => $validated['correo'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'celular' => $validated['celular'] ?? null,
                'extension' => $validated['extension'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
            ]);
        });

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Contacto actualizado exitosamente.');
    }

    public function updateNota(Request $request, $id)
    {
        $validated = $request->validate([
            'observaciones' => 'nullable|string|max:255',
        ]);

        $contacto = Contacto::findOrFail($id);

        $asignacion = Asignacion::where('contacto_id', $contacto->id)
            ->where('activo', true)
            ->first();

        if (!$asignacion) {
            return back()->withErrors([
                'observaciones' => 'El contacto no tiene una asignación activa.',
            ]);
        }

        $asignacion->update([
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Nota guardada exitosamente.');
    }

    public function verificarAsignacion(Request $request)
    {
        $validated = $request->validate([
            'ente_id' => 'required|exists:entes,id',
            'puesto_id' => 'required|exists:puestos,id',
        ]);

        $asignacion = Asignacion::with([
            'contacto',
            'ente',
            'puesto',
            'sede',
        ])
            ->where('ente_id', $validated['ente_id'])
            ->where('puesto_id', $validated['puesto_id'])
            ->where('activo', true)
            ->first();

        return response()->json([
            'existe' => (bool) $asignacion,
            'asignacion' => $asignacion,
        ]);
    }

    public function reemplazar(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:50',
            'celular' => 'nullable|string|max:50',
            'extension' => 'nullable|string|max:20',
            'puesto_id' => 'required|exists:puestos,id',
            'ente_id' => 'required|exists:entes,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'observaciones' => 'nullable|string|max:255',
        ]);

        if (
            empty($validated['correo']) &&
            empty($validated['telefono']) &&
            empty($validated['celular'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'correo' => 'Debe registrar al menos un medio de comunicación: correo, teléfono o celular.',
                ]);
        }

        DB::transaction(function () use ($validated) {
            $asignacionExistente = Asignacion::where('ente_id', $validated['ente_id'])
                ->where('puesto_id', $validated['puesto_id'])
                ->where('activo', true)
                ->lockForUpdate()
                ->firstOrFail();

            $asignacionExistente->update([
                'fecha_fin' => now()->toDateString(),
                'activo' => false,
            ]);

            $contacto = Contacto::create([
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'activo' => true,
            ]);

            Asignacion::create([
                'contacto_id' => $contacto->id,
                'puesto_id' => $validated['puesto_id'],
                'ente_id' => $validated['ente_id'],
                'sede_id' => $validated['sede_id'] ?? null,
                'correo' => $validated['correo'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'celular' => $validated['celular'] ?? null,
                'extension' => $validated['extension'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => null,
                'activo' => true,
            ]);
        });

        return redirect()
            ->route('contactos.index')
            ->with('success', 'Asignación reemplazada exitosamente.');
    }
}