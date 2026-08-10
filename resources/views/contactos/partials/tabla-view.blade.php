<div class="card border-0 shadow-sm rounded-lg mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tablaContactos" style="width:100%;">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="border-top-0 pl-3 py-3" style="width: 30%;">Servidor Público / Puesto</th>
                        <th class="border-top-0 py-3" style="width: 25%;">Ente y Sede</th>
                        <th class="border-top-0 py-3" style="width: 25%;">Datos de Contacto</th>
                        <th class="border-top-0 py-3" style="width: 10%;">Observaciones</th>
                        <th class="border-top-0 text-right pr-3 py-3" style="width: 10%;">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($asignaciones as $asignacion)
                        <tr style="cursor: pointer;" 
                            onclick="abrirInspector(this)"
                            data-id="{{ $asignacion->contacto_id }}"
                            data-nombre="{{ $asignacion->contacto->nombre ?? '' }}"
                            data-apellido_paterno="{{ $asignacion->contacto->apellido_paterno ?? '' }}"
                            data-apellido_materno="{{ $asignacion->contacto->apellido_materno ?? '' }}"
                            data-puesto="{{ $asignacion->puesto_id }}"
                            data-ente="{{ $asignacion->ente_id }}"
                            data-sede="{{ $asignacion->sede_id }}"
                            data-correo="{{ $asignacion->correo }}"
                            data-telefono="{{ $asignacion->telefono }}"
                            data-extension="{{ $asignacion->extension }}">
                            
                            <td class="align-middle pl-3">
                                <div class="font-weight-bold text-dark" style="font-family: 'Montserrat', sans-serif;">
                                    {{ $asignacion->contacto->nombre ?? '' }} 
                                    {{ $asignacion->contacto->apellido_paterno ?? '' }} 
                                    {{ $asignacion->contacto->apellido_materno ?? '' }}
                                </div>
                                <small class="text-muted d-block">{{ $asignacion->puesto->nombre ?? 'Sin puesto asignado' }}</small>
                            </td>
                            <td class="align-middle">
                                <div class="font-weight-bold text-gray-800">
                                    {{ $asignacion->ente->nombre ?? 'Sin Ente' }}
                                    @if($asignacion->ente && $asignacion->ente->siglas)
                                        <span class="text-muted font-weight-normal">({{ $asignacion->ente->siglas }})</span>
                                    @endif
                                </div>
                                @if($asignacion->sede && $asignacion->sede->nombre)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-building fa-xs mr-1 text-secondary"></i> {{ $asignacion->sede->nombre }}
                                    </small>
                                @endif
                            </td>
                            <td class="align-middle" style="font-family: 'JetBrains Mono', monospace; font-size: 85%;">
                                <div class="text-dark"><i class="far fa-envelope fa-xs mr-1 text-muted"></i> {{ $asignacion->correo ?? 'Sin correo' }}</div>
                                <div class="text-muted mt-1">
                                    <i class="fas fa-phone-alt fa-xs mr-1 text-muted"></i> {{ $asignacion->telefono ?? 'N/D' }} 
                                    @if($asignacion->extension)
                                        <span class="badge badge-light border ml-1">Ext. {{ $asignacion->extension }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                @if(!empty($asignacion->contacto->observaciones))
                                    <span class="text-truncate d-inline-block text-muted small" style="max-width: 150px;" title="{{ $asignacion->contacto->observaciones }}">
                                        <i class="fas fa-comment-alt text-primary fa-xs mr-1"></i> {{ $asignacion->contacto->observaciones }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="align-middle text-right pr-3" onclick="event.stopPropagation();">
                                <div class="btn-group" role="group">
                                    <!-- Botón de nota -->
                                    <button type="button" class="btn btn-sm btn-light text-secondary border-0 rounded mr-1 px-2 btn-nota-contacto" 
                                            data-id="{{ $asignacion->contacto_id }}" 
                                            data-nombre="{{ trim(($asignacion->contacto->nombre ?? '') . ' ' . ($asignacion->contacto->apellido_paterno ?? '')) }}" 
                                            data-observaciones="{{ $asignacion->contacto->observaciones ?? '' }}" 
                                            title="Añadir nota">
                                        <i class="fas fa-comment-alt fa-xs"></i>
                                    </button>
                                    <!-- Botón de lápiz explícito para editar -->
                                    <button type="button" class="btn btn-sm btn-light text-primary border-0 rounded px-2" 
                                            onclick="abrirInspector(this.closest('tr'))" 
                                            title="Editar">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>