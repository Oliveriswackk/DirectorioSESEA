<!-- Modal Crear Estado -->
<div class="modal fade" id="modalCrearEstado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-gray-800">Registrar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('estados.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="nombre" class="small font-weight-bold">Nombre del Estado</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Chihuahua" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales Editar Estado -->
@foreach($estados as $estado)
<div class="modal fade" id="modalEditarEstado{{ $estado->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-gray-800">Editar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('estados.update', $estado) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Nombre del Estado</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $estado->nombre }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach