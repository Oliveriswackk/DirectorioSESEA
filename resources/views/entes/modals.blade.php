<!-- 1. Modal Crear Ente -->
<div class="modal fade" id="modalCrearEnte" tabindex="-1" role="dialog" aria-labelledby="modalCrearEnteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark" id="modalCrearEnteLabel">Registrar Nuevo Ente</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('entes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="small font-weight-bold text-dark">Nombre del Ente <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control form-control-sm" required placeholder="Ej. Secretaría de Hacienda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small font-weight-bold text-dark">Siglas</label>
                            <input type="text" name="siglas" class="form-control form-control-sm" placeholder="Ej. SHCP">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-dark">Nivel de Gobierno <span class="text-danger">*</span></label>
                            <select name="nivel_gobierno_id" class="form-control form-control-sm select-search" required>
                                <option value="">Seleccione nivel...</option>
                                @foreach($nivelesGobierno as $nivel)
                                    <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-dark">Municipio (Opcional)</label>
                            <select name="municipio_id" class="form-control form-control-sm select-search">
                                <option value="">Seleccione municipio...</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">
                                        {{ $municipio->nombre }} @if($municipio->estado) ({{ $municipio->estado->nombre }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Ente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Modal ÚNICO de Edición Reutilizable -->
<div class="modal fade" id="modalEditarEnte" tabindex="-1" role="dialog" aria-labelledby="modalEditarEnteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark" id="modalEditarEnteLabel">Editar Ente</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEditarEnte" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="small font-weight-bold text-dark">Nombre del Ente <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small font-weight-bold text-dark">Siglas</label>
                            <input type="text" name="siglas" id="edit_siglas" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-dark">Nivel de Gobierno <span class="text-danger">*</span></label>
                            <select name="nivel_gobierno_id" id="edit_nivel_gobierno_id" class="form-control form-control-sm select-search" required>
                                <option value="">Seleccione nivel...</option>
                                @foreach($nivelesGobierno as $nivel)
                                    <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-dark">Municipio (Opcional)</label>
                            <select name="municipio_id" id="edit_municipio_id" class="form-control form-control-sm select-search">
                                <option value="">Seleccione municipio...</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">
                                        {{ $municipio->nombre }} @if($municipio->estado) ({{ $municipio->estado->nombre }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar Ente</button>
                </div>
            </form>
        </div>
    </div>
</div>