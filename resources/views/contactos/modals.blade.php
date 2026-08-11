<!-- ================================================================= -->
<!-- MODAL: CREAR NUEVA ASIGNACIÓN / CONTACTO                          -->
<!-- ================================================================= -->
<div class="modal fade" id="modalCrearContacto" tabindex="-1" role="dialog" aria-labelledby="modalCrearContactoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            
            <div class="modal-header bg-light border-0 px-4 pt-4 pb-3" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="modal-title font-weight-bold text-gray-900" id="modalCrearContactoLabel">
                    <i class="fas fa-user-plus text-primary mr-2"></i> Registrar Nuevo Contacto y Asignación
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('contactos.store') }}" method="POST" class="user">
                @csrf
                <div class="modal-body px-4 py-3">
                    
                    <!-- Bloque 1: Datos Personales -->
                    <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">1. Información Personal</h6>
                    <div class="row">
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control bg-light" required placeholder="Ej. Juan Carlos">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" name="apellido_paterno" class="form-control bg-light" required placeholder="Ej. Pérez">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control bg-light" placeholder="Ej. Gómez">
                        </div>
                    </div>

                    <!-- Bloque 2: Ubicación Institucional -->
                    <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">2. Ubicación Institucional</h6>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">
                                Ente <span class="text-danger">*</span>
                                <i class="fas fa-info-circle text-muted ml-1" data-toggle="tooltip" title="Dependencia u organismo al que se encuentra adscrito el contacto."></i>
                            </label>
                            <select name="ente_id" class="form-control bg-light" required>
                                <option value="">Seleccione un Ente...</option>
                                @foreach($entes ?? [] as $ente)
                                    <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">
                                Puesto <span class="text-danger">*</span>
                                <i class="fas fa-info-circle text-muted ml-1" data-toggle="tooltip" title="Cargo o jerarquía que desempeña dentro de la institución."></i>
                            </label>
                            <select name="puesto_id" class="form-control bg-light" required>
                                <option value="">Seleccione un Puesto...</option>
                                @foreach($puestos ?? [] as $puesto)
                                    <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Sede</label>
                            <select name="sede_id" class="form-control bg-light">
                                <option value="">Seleccione una Sede (Opcional)...</option>
                                @foreach($sedes ?? [] as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Bloque 3: Medios de Contacto -->
                    <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">3. Medios de Comunicación</h6>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Correo Institucional <span class="text-danger">*</span></label>
                            <input type="email" name="correo" class="form-control bg-light" required placeholder="correo@seseachihuahua.gob.mx">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Teléfono</label>
                            <input type="text" name="telefono" class="form-control bg-light" placeholder="(614) 000-0000">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold text-gray-700 small">Extensión</label>
                            <input type="text" name="extension" class="form-control bg-light" placeholder="Ej. 104">
                        </div>
                    </div>

                    <!-- Bloque 4: Notas u Observaciones iniciales -->
                    <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">4. Observaciones Iniciales</h6>
                    <div class="row">
                        <div class="col-md-12 form-group mb-0">
                            <textarea name="observaciones" class="form-control bg-light" rows="3" placeholder="Notas internas relevantes sobre este contacto..."></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ================================================================= -->
<!-- MODALES DINÁMICOS POR CADA CONTACTO (DETALLES, EDITAR, NOTAS)      -->
<!-- ================================================================= -->
@foreach($contactos ?? [] as $contacto)
    
    @php
        $asignacionActual = $contacto->asignaciones->where('activo', true)->first() ?? $contacto->asignaciones->first();
    @endphp

    <!-- 1. MODAL DE DETALLES Y NOTAS EXTENDIDAS -->
    <div class="modal fade" id="modalDetalles{{ $contacto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
                <div class="modal-header bg-light border-0 px-4 pt-4 pb-3" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <h5 class="modal-title font-weight-bold text-gray-900">
                        <i class="fas fa-id-card text-info mr-2"></i> Ficha Detallada: {{ $contacto->nombre }} {{ $contacto->apellido_paterno }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4 py-3">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Nombre Completo</span>
                            <p class="text-gray-900 font-weight-bold mb-1">{{ $contacto->nombre }} {{ $contacto->apellido_paterno }} {{ $contacto->apellido_materno }}</p>
                        </div>
                        <div class="col-md-6">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Estado del Contacto</span>
                            <p class="mb-1">
                                @if($contacto->activo)
                                    <span class="badge badge-success px-2 py-1">Activo</span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">Inactivo</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Ente Adscrito</span>
                            <p class="text-gray-800 mb-1">{{ $asignacionActual->ente->nombre ?? 'Sin Ente Asignado' }}</p>
                        </div>
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Puesto / Cargo</span>
                            <p class="text-gray-800 mb-1">{{ $asignacionActual->puesto->nombre ?? 'Sin Puesto Asignado' }}</p>
                        </div>
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Última Actualización (Vigencia)</span>
                            <p class="text-gray-800 mb-1"><i class="fas fa-history text-muted mr-1"></i> {{ $contacto->updated_at ? $contacto->updated_at->diffForHumans() : 'N/D' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Correo Institucional</span>
                            <p class="text-gray-800 mb-1">{{ $asignacionActual->correo ?? 'No registrado' }}</p>
                        </div>
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Teléfono / Extensión</span>
                            <p class="text-gray-800 mb-1">{{ $asignacionActual->telefono ?? 'N/D' }} @if($asignacionActual->extension) (Ext. {{ $asignacionActual->extension }}) @endif</p>
                        </div>
                        <div class="col-md-4">
                            <span class="text-xs font-weight-bold text-uppercase text-muted">Sede</span>
                            <p class="text-gray-800 mb-1">{{ $asignacionActual->sede->nombre ?? 'Sede Principal' }}</p>
                        </div>
                    </div>

                    <!-- SECCIÓN EXTENDIDA DE NOTAS Y OBSERVACIONES CON OPCIÓN DE RESOLVER -->
                    <div class="card border-left-warning shadow-sm bg-light">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="font-weight-bold text-warning mb-0"><i class="fas fa-sticky-note mr-1"></i> Nota / Observación Registrada</h6>
                                <span class="text-muted small">Actualizado: {{ $contacto->updated_at ? $contacto->updated_at->format('d/m/Y H:i') : '' }}</span>
                            </div>
                            
                            <!-- Texto completo de la nota bien visible para que no se corte -->
                            <div class="bg-white p-3 rounded border mb-2 text-gray-800" style="max-height: 150px; overflow-y: auto; font-size: 0.9rem;">
                                {{ $contacto->observaciones ?? 'No hay observaciones adicionales registradas para este contacto.' }}
                            </div>

                            <!-- Botón para marcar observación como resuelta (Solo disponible para Admin o Coordinador) -->
                            @if(auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Coordinador')))
                                @if(!empty($contacto->observaciones))
                                    <form action="{{ route('contactos.update-nota', $contacto->id) }}" method="POST" class="text-right">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="observaciones" value="">
                                        <button type="submit" class="btn btn-sm btn-outline-success font-weight-bold shadow-sm" onclick="return confirm('¿Confirma que desea marcar esta observación como atendida/resuelta?');">
                                            <i class="fas fa-check-circle mr-1"></i> Marcar Observación como Resuelta
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 2. MODAL DE EDITAR CONTACTO Y ASIGNACIÓN -->
    <div class="modal fade" id="modalEditarContacto{{ $contacto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
                
                <div class="modal-header bg-light border-0 px-4 pt-4 pb-3" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <h5 class="modal-title font-weight-bold text-gray-900">
                        <i class="fas fa-user-edit text-primary mr-2"></i> Editar Contacto: {{ $contacto->nombre }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('contactos.update', $contacto->id) }}" method="POST" class="user">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-body px-4 py-3">
                        
                        <!-- Bloque 1: Datos Personales -->
                        <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">1. Información Personal</h6>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control bg-light" required value="{{ old('nombre', $contacto->nombre) }}">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="apellido_paterno" class="form-control bg-light" required value="{{ old('apellido_paterno', $contacto->apellido_paterno) }}">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Apellido Materno</label>
                                <input type="text" name="apellido_materno" class="form-control bg-light" value="{{ old('apellido_materno', $contacto->apellido_materno) }}">
                            </div>
                        </div>

                        <!-- Bloque 2: Ubicación Institucional (Selects con valores actuales corregidos) -->
                        <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">2. Ubicación Institucional</h6>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Ente <span class="text-danger">*</span></label>
                                <select name="ente_id" class="form-control bg-light" required>
                                    <option value="">Seleccione un Ente...</option>
                                    @foreach($entes ?? [] as $ente)
                                        <option value="{{ $ente->id }}" {{ (optional($asignacionActual)->ente_id == $ente->id) ? 'selected' : '' }}>
                                            {{ $ente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Puesto <span class="text-danger">*</span></label>
                                <select name="puesto_id" class="form-control bg-light" required>
                                    <option value="">Seleccione un Puesto...</option>
                                    @foreach($puestos ?? [] as $puesto)
                                        <option value="{{ $puesto->id }}" {{ (optional($asignacionActual)->puesto_id == $puesto->id) ? 'selected' : '' }}>
                                            {{ $puesto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Sede</label>
                                <select name="sede_id" class="form-control bg-light">
                                    <option value="">Seleccione una Sede (Opcional)...</option>
                                    @foreach($sedes ?? [] as $sede)
                                        <option value="{{ $sede->id }}" {{ (optional($asignacionActual)->sede_id == $sede->id) ? 'selected' : '' }}>
                                            {{ $sede->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Bloque 3: Medios de Contacto -->
                        <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">3. Medios de Comunicación</h6>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Correo Institucional <span class="text-danger">*</span></label>
                                <input type="email" name="correo" class="form-control bg-light" required value="{{ old('correo', optional($asignacionActual)->correo) }}">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Teléfono</label>
                                <input type="text" name="telefono" class="form-control bg-light" value="{{ old('telefono', optional($asignacionActual)->telefono) }}">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Extensión</label>
                                <input type="text" name="extension" class="form-control bg-light" value="{{ old('extension', optional($asignacionActual)->extension) }}">
                            </div>
                        </div>

                        <!-- Bloque 4: Estatus y Nota -->
                        <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 mt-4 border-bottom pb-1">4. Estatus y Observaciones</h6>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold text-gray-700 small">Estado del Contacto</label>
                                <select name="activo" class="form-control bg-light">
                                    <option value="1" {{ $contacto->activo ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ !$contacto->activo ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-8 form-group mb-0">
                                <label class="font-weight-bold text-gray-700 small">Observaciones / Notas</label>
                                <textarea name="observaciones" class="form-control bg-light" rows="2">{{ old('observaciones', $contacto->observaciones) }}</textarea>
                            </div>
                        </div>

                    </div>
                    
                    <div class="modal-footer bg-light border-0 px-4 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- 3. MODAL DE NOTAS RÁPIDAS (ACCESO INDIVIDUAL) -->
    <div class="modal fade" id="modalNota{{ $contacto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
                <div class="modal-header bg-light border-0 px-4 pt-4 pb-3" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <h5 class="modal-title font-weight-bold text-gray-900">
                        <i class="fas fa-sticky-note text-warning mr-2"></i> Nota de {{ $contacto->nombre }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('contactos.update-nota', $contacto->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body px-4 py-3">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold text-gray-700 small">Actualizar observaciones / notas de seguimiento:</label>
                            <textarea name="observaciones" class="form-control bg-light" rows="4" placeholder="Escriba aquí la nota...">{{ $contacto->observaciones }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 px-4 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                        <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm text-dark">Guardar Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endforeach