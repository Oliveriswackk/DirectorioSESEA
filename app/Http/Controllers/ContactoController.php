<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Contacto;
use App\Models\Puesto;
use App\Models\Ente;
use App\Models\Sede;
use App\Models\NivelGobierno;
use App\Services\BitacoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function __construct(
        private BitacoraService $bitacora
    ) {
    }

    public function index()
    {
        $asignaciones = Asignacion::with([
            'contacto',
            'puesto',
            'ente.nivelGobierno',
            'ente.municipio.estado',
            'sede',
        ])
            ->where('activo', true)
            ->get();

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

        /*
        |--------------------------------------------------------------------------
        | Verificar si ya existe un titular activo
        |--------------------------------------------------------------------------
        */

        $asignacionExistente = Asignacion::with('contacto')
            ->where('ente_id', $validated['ente_id'])
            ->where('puesto_id', $validated['puesto_id'])
            ->where('activo', true)
            ->first();

        if ($asignacionExistente) {

            $medio = null;
            $tipoMedio = null;

            if (!empty($asignacionExistente->correo)) {

                $medio = $asignacionExistente->correo;
                $tipoMedio = 'Correo institucional';

            } elseif (!empty($asignacionExistente->telefono)) {

                $medio = $asignacionExistente->telefono;
                $tipoMedio = 'Teléfono';

            } elseif (!empty($asignacionExistente->celular)) {

                $medio = $asignacionExistente->celular;
                $tipoMedio = 'Celular';
            }

            return back()
                ->withInput()
                ->with('asignacion_existente', [
                    'contacto_id' => $asignacionExistente->contacto_id,

                    'nombre' => trim(
                        $asignacionExistente->contacto->nombre . ' ' .
                        ($asignacionExistente->contacto->apellido_paterno ?? '') . ' ' .
                        ($asignacionExistente->contacto->apellido_materno ?? '')
                    ),

                    'tipo_medio' => $tipoMedio,
                    'medio' => $medio,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Registrar contacto y asignación
        |--------------------------------------------------------------------------
        */

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

            $this->bitacora->registrar(
                'Contacto',
                $contacto->id,
                'registro_contacto',
                'Se registró un nuevo contacto en el Directorio.'
            );
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
                ->withInput()
                ->withErrors([
                    'contacto' => 'El contacto no tiene una asignación registrada.',
                ]);
        }

        $cambioDeAsignacion =
            $asignacion->ente_id != $validated['ente_id'] ||
            $asignacion->puesto_id != $validated['puesto_id'] ||
            $asignacion->sede_id != ($validated['sede_id'] ?? null);

        DB::transaction(function () use (
            $validated,
            $contacto,
            $asignacion,
            $cambioDeAsignacion
        ) {
            $contacto->update([
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                'apellido_materno' => $validated['apellido_materno'] ?? null,
            ]);

            if ($cambioDeAsignacion) {

                $asignacion->update([
                    'fecha_fin' => now()->toDateString(),
                    'activo' => false,
                ]);

                Asignacion::create([
                    'contacto_id' => $contacto->id,
                    'ente_id' => $validated['ente_id'],
                    'sede_id' => $validated['sede_id'] ?? null,
                    'puesto_id' => $validated['puesto_id'],

                    'correo' => $validated['correo'] ?? null,
                    'telefono' => $validated['telefono'] ?? null,
                    'celular' => $validated['celular'] ?? null,
                    'extension' => $validated['extension'] ?? null,
                    'observaciones' => $validated['observaciones'] ?? null,

                    'fecha_inicio' => now()->toDateString(),
                    'fecha_fin' => null,
                    'activo' => true,
                ]);

            } else {

                $asignacion->update([
                    'correo' => $validated['correo'] ?? null,
                    'telefono' => $validated['telefono'] ?? null,
                    'celular' => $validated['celular'] ?? null,
                    'extension' => $validated['extension'] ?? null,
                    'observaciones' => $validated['observaciones'] ?? null,
                ]);
            }
        });

        $this->bitacora->registrar(
            'Contacto',
            $contacto->id,
            'modificacion_contacto',
            $cambioDeAsignacion
                ? 'Se modificó la información del contacto y su asignación.'
                : 'Se modificó la información del contacto.'
        );

        return redirect()
            ->route('contactos.index')
            ->with(
                'success',
                $cambioDeAsignacion
                    ? 'Cambio de asignación registrado correctamente.'
                    : 'Contacto actualizado correctamente.'
            );
    }


    public function updateNota(Request $request, $id, BitacoraService $bitacora)
    {
        $validated = $request->validate([
            'observacion' => 'required|string|max:255',
        ]);

        $contacto = Contacto::findOrFail($id);

        $asignacion = Asignacion::where('contacto_id', $contacto->id)
            ->where('activo', true)
            ->first();

        if (!$asignacion) {
            return back()->withErrors([
                'observacion' => 'El contacto no tiene una asignación activa.',
            ]);
        }

        $nuevaObservacion = trim($validated['observacion']);

        /*
        |--------------------------------------------------------------------------
        | AGREGAR LA NUEVA OBSERVACIÓN
        |--------------------------------------------------------------------------
        */

        $observacionesActuales = trim(
            $asignacion->observaciones ?? ''
        );

        if ($observacionesActuales !== '') {

            $observacionesActuales .= "\n";

        }

        $observacionesActuales .= '• ' . $nuevaObservacion;


        /*
        |--------------------------------------------------------------------------
        | GUARDAR
        |--------------------------------------------------------------------------
        */

        $asignacion->update([
            'observaciones' => $observacionesActuales,
        ]);


        /*
        |--------------------------------------------------------------------------
        | BITÁCORA
        |--------------------------------------------------------------------------
        */

        $bitacora->registrar(
            'Contacto',
            $contacto->id,
            'agrego_observacion',
            'Se agregó una observación al contacto.'
        );


        return redirect()
            ->route('contactos.index')
            ->with(
                'success',
                'Observación agregada correctamente.'
            );
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


    public function reemplazar(Request $request, $id, BitacoraService $bitacora)
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

        $contactoAnterior = Contacto::findOrFail($id);

        $nuevaAsignacion = null;

        DB::transaction(function () use (
            $validated,
            $contactoAnterior,
            &$nuevaAsignacion
        ) {

            $asignacionExistente = Asignacion::where(
                'ente_id',
                $validated['ente_id']
            )
                ->where('puesto_id', $validated['puesto_id'])
                ->where('activo', true)
                ->lockForUpdate()
                ->firstOrFail();


            $asignacionExistente->update([
                'fecha_fin' => now()->toDateString(),
                'activo' => false,
            ]);


            $nuevoContacto = Contacto::create([
                'nombre' => $validated['nombre'],
                'apellido_paterno' => $validated['apellido_paterno'] ?? null,
                'apellido_materno' => $validated['apellido_materno'] ?? null,
                'activo' => true,
            ]);


            $nuevaAsignacion = Asignacion::create([
                'contacto_id' => $nuevoContacto->id,
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


        $bitacora->registrar(
            'Asignacion',
            $nuevaAsignacion->id,
            'reemplazo_asignacion',
            'Se reemplazó al titular de una asignación.'
        );


        return redirect()
            ->route('contactos.index')
            ->with('success', 'Asignación reemplazada exitosamente.');
    }
}