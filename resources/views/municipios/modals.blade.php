<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearMunicipio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Registrar Nuevo Municipio</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('municipios.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Estado <span class="text-danger">*</span></label>
                        <select name="estado_id" class="form-control form-control-sm select-search" required>
                            <option value="">Seleccione estado...</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Nombre del Municipio <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control form-control-sm" required placeholder="Ej. Juárez">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Municipio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Único de Edición Reutilizable -->
<div class="modal fade" id="modalEditarMunicipio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Editar Municipio</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEditarMunicipio" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Estado <span class="text-danger">*</span></label>
                        <select name="estado_id" id="edit_estado_id" class="form-control form-control-sm select-search" required>
                            <option value="">Seleccione estado...</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Nombre del Municipio <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="edit_nombre_municipio" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar Municipio</button>
                </div>
            </form>
        </div>
    </div>
</div>