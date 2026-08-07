<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearMunicipio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title h6 font-weight-bold mb-0">
                    <i class="fas fa-plus mr-1"></i> Registrar Nuevo Municipio
                </h5>
                <button type="button" class="close text-white opacity-8" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('municipios.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted">Estado Perteneciente</label>
                        <select name="estado_id" class="select-search" required>
                            <option value="">-- Seleccionar Estado --</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $estado_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-muted">Nombre del Municipio</label>
                        <input type="text" name="nombre" class="form-control bg-light border-0 small" 
                               placeholder="Ej. Juárez, Delicias, Parral" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-2 px-4">
                    <button type="button" class="btn btn-sm btn-secondary rounded" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales Editar Municipio -->
@foreach($municipios as $municipio)
<div class="modal fade" id="modalEditarMunicipio{{ $municipio->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title h6 font-weight-bold text-dark mb-0">
                    <i class="fas fa-pen text-primary mr-1"></i> Editar Municipio
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('municipios.update', $municipio) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-muted">Estado Perteneciente</label>
                        <select name="estado_id" class="custom-select custom-select-sm" required>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $municipio->estado_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-muted">Nombre del Municipio</label>
                        <input type="text" name="nombre" class="form-control bg-light border-0 small" 
                               value="{{ $municipio->nombre }}" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-2 px-4">
                    <button type="button" class="btn btn-sm btn-secondary rounded" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach