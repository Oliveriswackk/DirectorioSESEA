<!-- Modal Crear Sede -->
<div class="modal fade" id="modalCrearSede" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Registrar Nueva Sede</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('sedes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Ente Perteneciente <span class="text-danger">*</span></label>
                        <select name="ente_id" class="form-control form-control-sm select-search" required>
                            <option value="">Seleccione ente...</option>
                            @foreach($entes as $ente)
                                <option value="{{ $ente->id }}">
                                    {{ $ente->nombre }} @if($ente->siglas) ({{ $ente->siglas }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Nombre de la Sede <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control form-control-sm" required placeholder="Ej. Edificio Central / Campus Norte">
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Dirección (Texto descriptivo)</label>
                        <textarea name="direccion_texto" class="form-control form-control-sm" rows="3" placeholder="Ej. Av. Universidad #1200, Col. Centro"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Sede</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Único de Edición Reutilizable -->
<div class="modal fade" id="modalEditarSede" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Editar Sede</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEditarSede" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Ente Perteneciente <span class="text-danger">*</span></label>
                        <select name="ente_id" id="edit_ente_id" class="form-control form-control-sm select-search" required>
                            <option value="">Seleccione ente...</option>
                            @foreach($entes as $ente)
                                <option value="{{ $ente->id }}">
                                    {{ $ente->nombre }} @if($ente->siglas) ({{ $ente->siglas }}) @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Nombre de la Sede <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="edit_nombre_sede" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Dirección (Texto descriptivo)</label>
                        <textarea name="direccion_texto" id="edit_direccion_texto" class="form-control form-control-sm" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar Sede</button>
                </div>
            </form>
        </div>
    </div>
</div>