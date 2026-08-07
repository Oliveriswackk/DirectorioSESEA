<!-- Modal Crear Estado -->
<div class="modal fade" id="modalCrearEstado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Registrar Nuevo Estado</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('estados.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Nombre del Estado <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control form-control-sm" required placeholder="Ej. Chihuahua">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Único de Edición Reutilizable -->
<div class="modal fade" id="modalEditarEstado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title h6 font-weight-bold text-dark">Editar Estado</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEditarEstado" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-dark">Nombre del Estado <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="edit_nombre_estado" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div>