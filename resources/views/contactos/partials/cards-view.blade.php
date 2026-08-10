<div class="row" id="contenedorCards">
    @foreach($asignaciones as $asignacion)
        <div class="col-xl-3 col-md-4 col-sm-6 mb-3 contacto-card-item"
             data-nivel="{{ $asignacion->ente->nivel_gobierno ?? '' }}"
             data-ente="{{ $asignacion->ente->nombre ?? '' }}"
             data-puesto="{{ $asignacion->puesto->nombre ?? '' }}">
             
            <div class="card border-0 shadow-sm rounded-lg h-100" 
                 style="cursor: pointer;" 
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
                 
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <!-- Indicador visual del Nivel de Gobierno -->
                        @if(!empty($asignacion->ente->nivel_gobierno))
                            <span class="badge badge-light border text-muted mb-2 font-weight-normal" style="font-size: 70%;">
                                <i class="fas fa-landmark fa-xs mr-1"></i> {{ $asignacion->ente->nivel_gobierno }}
                            </span>
                        @endif

                        <h6 class="font-weight-bold text-dark mb-1" style="font-family: 'Montserrat', sans-serif;">
                            {{ $asignacion->contacto->nombre ?? '' }} 
                            {{ $asignacion->contacto->apellido_paterno ?? '' }}
                        </h6>
                        <span class="text-muted small d-block mb-2">
                            {{ $asignacion->puesto->nombre ?? 'Sin puesto asignado' }}
                        </span>

                        <div class="bg-light p-2 rounded small mb-2">
                            <strong class="text-gray-800 d-block">{{ $asignacion->ente->nombre ?? 'Sin Ente' }}</strong>
                            @if($asignacion->sede && $asignacion->sede->nombre)
                                <span class="text-muted" style="font-size: 80%;">
                                    <i class="fas fa-building fa-xs mr-1"></i> {{ $asignacion->sede->nombre }}
                                </span>
                            @endif
                        </div>

                        <div class="small text-muted" style="font-family: 'JetBrains Mono', monospace; font-size: 80%;">
                            <div><i class="far fa-envelope fa-xs mr-1"></i> {{ $asignacion->correo ?? 'Sin correo' }}</div>
                            <div><i class="fas fa-phone-alt fa-xs mr-1"></i> {{ $asignacion->telefono ?? 'N/D' }}</div>
                        </div>
                    </div>

                    <!-- Botones de acción aislados en la tarjeta -->
                    <div class="text-right mt-3 border-top pt-2 d-flex justify-content-end align-items-center" onclick="event.stopPropagation();">
                        <button type="button" 
                                class="btn btn-sm btn-light text-secondary border px-2 mr-1 btn-nota-contacto" 
                                data-id="{{ $asignacion->contacto_id }}"
                                data-nombre="{{ trim(($asignacion->contacto->nombre ?? '') . ' ' . ($asignacion->contacto->apellido_paterno ?? '')) }}"
                                data-observaciones="{{ $asignacion->contacto->observaciones ?? '' }}"
                                title="Añadir nota">
                            <i class="fas fa-comment-alt fa-xs"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-light text-primary border px-2" 
                                onclick="abrirInspector(this.closest('.contacto-card-item').querySelector('.card'))"
                                title="Editar">
                            <i class="fas fa-pen fa-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>