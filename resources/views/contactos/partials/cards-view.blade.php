<div id="contenedorCards">

    <div class="row" id="gridCards">

        @foreach($asignaciones as $asignacion)

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 contacto-card-item"

                data-nivel-id="{{ $asignacion->ente->nivel_gobierno_id ?? '' }}"
                data-ente-id="{{ $asignacion->ente_id ?? '' }}"
                data-puesto-id="{{ $asignacion->puesto_id ?? '' }}"
                data-activo="{{ $asignacion->activo ? '1' : '0' }}"

                data-busqueda="
                    {{ strtolower(
                        ($asignacion->contacto->nombre ?? '') . ' ' .
                        ($asignacion->contacto->apellido_paterno ?? '') . ' ' .
                        ($asignacion->contacto->apellido_materno ?? '') . ' ' .
                        ($asignacion->puesto->nombre ?? '') . ' ' .
                        ($asignacion->ente->nombre ?? '') . ' ' .
                        ($asignacion->ente->siglas ?? '') . ' ' .
                        ($asignacion->sede->nombre ?? '') . ' ' .
                        ($asignacion->correo ?? '') . ' ' .
                        ($asignacion->telefono ?? '')
                    ) }}"
            >

                <div class="card border-0 shadow-sm rounded-lg h-100"
                    style="cursor: pointer;"
                    onclick="abrirInspector(this)"

                    data-id="{{ $asignacion->contacto_id }}"

                    data-nombre="{{ $asignacion->contacto->nombre ?? '' }}"
                    data-apellido_paterno="{{ $asignacion->contacto->apellido_paterno ?? '' }}"
                    data-apellido_materno="{{ $asignacion->contacto->apellido_materno ?? '' }}"

                    data-puesto-id="{{ $asignacion->puesto_id ?? '' }}"
                    data-puesto="{{ $asignacion->puesto->nombre ?? '' }}"

                    data-ente-id="{{ $asignacion->ente_id ?? '' }}"
                    data-ente="{{ $asignacion->ente->nombre ?? '' }}"

                    data-sede-id="{{ $asignacion->sede_id ?? '' }}"
                    data-sede="{{ $asignacion->sede->nombre ?? '' }}"
                    data-correo="{{ $asignacion->correo ?? '' }}"
                    data-telefono="{{ $asignacion->telefono ?? '' }}"
                    data-extension="{{ $asignacion->extension ?? '' }}"
                    data-celular="{{ $asignacion->celular ?? '' }}"
                    data-observaciones="{{ $asignacion->observaciones ?? '' }}"

                    data-nivel="{{ $asignacion->ente->nivelGobierno->nombre ?? '' }}"
                    data-municipio="{{ $asignacion->ente->municipio->nombre ?? '' }}"
                    data-estado="{{ $asignacion->ente->municipio->estado->nombre ?? '' }}"
                    data-direccion="{{ $asignacion->sede->direccion_texto ?? '' }}">
                >

                    <div class="card-body d-flex flex-column justify-content-between">

                        <div>

                            {{-- Nivel de gobierno --}}
                            @if($asignacion->ente && $asignacion->ente->nivelGobierno)

                                <span class="badge badge-light border text-muted mb-2 font-weight-normal"
                                    style="font-size: 70%;">

                                    <i class="fas fa-landmark fa-xs mr-1"></i>

                                    {{ $asignacion->ente->nivelGobierno->nombre }}

                                </span>

                            @endif


                            {{-- Nombre --}}
                            <h6 class="font-weight-bold text-dark mb-1"
                                style="font-family: 'Montserrat', sans-serif;">

                                {{ $asignacion->contacto->nombre ?? '' }}
                                {{ $asignacion->contacto->apellido_paterno ?? '' }}
                                {{ $asignacion->contacto->apellido_materno ?? '' }}

                            </h6>


                            {{-- Puesto --}}
                            <span class="text-muted small d-block mb-2">

                                {{ $asignacion->puesto->nombre ?? 'Sin puesto asignado' }}

                            </span>


                            {{-- Ente / sede --}}
                            <div class="bg-light p-2 rounded small mb-2">

                                <strong class="text-gray-800 d-block">

                                    {{ $asignacion->ente->nombre ?? 'Sin Ente' }}

                                    @if($asignacion->ente && $asignacion->ente->siglas)

                                        <span class="text-muted font-weight-normal">
                                            ({{ $asignacion->ente->siglas }})
                                        </span>

                                    @endif

                                </strong>


                                @if($asignacion->sede && $asignacion->sede->nombre)

                                    <span class="text-muted"
                                        style="font-size: 80%;">

                                        <i class="fas fa-building fa-xs mr-1"></i>

                                        {{ $asignacion->sede->nombre }}

                                    </span>

                                @endif

                            </div>


                            {{-- Datos de contacto --}}
                            <div class="small text-muted"
                                style="font-family: 'JetBrains Mono', monospace; font-size: 80%;">

                                <div>

                                    <i class="far fa-envelope fa-xs mr-1"></i>

                                    {{ $asignacion->correo ?? 'Sin correo' }}

                                </div>


                                <div class="mt-1">

                                    <i class="fas fa-phone-alt fa-xs mr-1"></i>

                                    {{ $asignacion->telefono ?? 'N/D' }}

                                    @if($asignacion->extension)

                                        <span class="badge badge-light border ml-1">
                                            Ext. {{ $asignacion->extension }}
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Acciones --}}
                        <div class="text-right mt-3 border-top pt-2 d-flex justify-content-end align-items-center"
                            onclick="event.stopPropagation();">


                            {{-- Nota --}}
                            <button type="button"

                                class="btn btn-sm btn-light text-secondary border px-2 mr-1 btn-nota-contacto"

                                data-id="{{ $asignacion->contacto_id }}"

                                data-nombre="{{ trim(
                                    ($asignacion->contacto->nombre ?? '') . ' ' .
                                    ($asignacion->contacto->apellido_paterno ?? '')
                                ) }}"

                                data-observaciones="{{ $asignacion->observaciones ?? '' }}"

                                title="Añadir nota"
                            >

                                <i class="fas fa-comment-alt fa-xs"></i>

                            </button>


                            {{-- Editar --}}
                            <button type="button"

                                class="btn btn-sm btn-light text-primary border px-2"

                                onclick="abrirInspector(this.closest('.card'))"

                                title="Editar"
                            >

                                <i class="fas fa-pen fa-xs"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    {{-- Paginación de cards --}}
    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="small text-muted" id="cardsInfo">
            Mostrando 0 de 0
        </div>

        <div id="cardsPagination"></div>

    </div>

</div>