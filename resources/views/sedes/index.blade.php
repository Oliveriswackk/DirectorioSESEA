@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Sedes</h1>
            <p class="text-muted small mb-0">Gestión de sedes e instalaciones institucionales</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearSede">
            <i class="fas fa-plus fa-xs mr-1"></i> Nueva Sede
        </button>
    </div>

    <!-- Tarjeta con Filtros y Buscador -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-header bg-white py-3 border-0">
            <form id="formFiltroSede" action="{{ route('sedes.index') }}" method="GET" class="form-row align-items-center justify-content-between">
                
                <!-- Buscador de Ente con Select -->
                <div class="col-12 col-md-5 mb-2 mb-md-0">
                    <div class="d-flex align-items-center">
                        <label for="selectEnte" class="small text-muted font-weight-bold mr-2 mb-0">Ente:</label>
                        <div class="flex-grow-1">
                            <select id="selectEnte" name="ente_id" class="select-search" onchange="document.getElementById('formFiltroSede').submit()">
                                <option value="">-- Todos los Entes --</option>
                                @foreach($entes as $ente)
                                    <option value="{{ $ente->id }}" {{ $ente_id == $ente->id ? 'selected' : '' }}>
                                        {{ $ente->nombre }} @if($ente->siglas) ({{ $ente->siglas }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buscador por Nombre de Sede / Dirección / Ente -->
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" 
                               name="search" 
                               id="inputSearchSede" 
                               class="form-control bg-light border-0 small" 
                               placeholder="Buscar sede (Enter)..." 
                               value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-search fa-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- Tabla -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="border-top-0 pl-4 py-3" style="width: 35%;">Nombre Sede</th>
                            <th class="border-top-0 py-3" style="width: 30%;">Ente Perteneciente</th>
                            <th class="border-top-0 py-3" style="width: 20%;">Dirección</th>
                            <th class="border-top-0 text-center py-3" style="width: 7%;">Estatus</th>
                            <th class="border-top-0 text-right pr-4 py-3" style="width: 8%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($sedes as $sede)
                            <tr>
                                <td class="align-middle pl-4 font-weight-bold text-dark">
                                    <i class="fas fa-building text-secondary mr-2 fa-xs"></i>{{ $sede->nombre }}
                                </td>
                                <td class="align-middle text-dark">
                                    <span class="font-weight-bold">{{ $sede->ente->nombre ?? 'N/A' }}</span>
                                    @if(optional($sede->ente)->siglas)
                                        <small class="badge badge-light border text-muted ml-1">{{ $sede->ente->siglas }}</small>
                                    @endif
                                </td>
                                <td class="align-middle text-muted small">
                                    {{ $sede->direccion_texto ?? 'Sin dirección registrada' }}
                                </td>

                                <!-- Switch Estatus -->
                                <td class="align-middle text-center">
                                    <form action="{{ route('sedes.toggle', $sede) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="custom-control custom-switch d-inline-block">
                                            <input type="checkbox" 
                                                   class="custom-control-input btn-confirm-switch-sede" 
                                                   id="switch-sede-{{ $sede->id }}" 
                                                   data-nombre="{{ $sede->nombre }}"
                                                   {{ $sede->activo ? 'checked' : '' }}>
                                            <label class="custom-control-label small {{ $sede->activo ? 'text-success font-weight-bold' : 'text-muted' }}" 
                                                   for="switch-sede-{{ $sede->id }}" style="cursor: pointer;">
                                                {{ $sede->activo ? 'Activo' : 'Inactivo' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>

                                <!-- Botón Editar (Lápiz) -->
                                <td class="align-middle text-right pr-4">
                                    <button type="button" 
                                            class="btn btn-sm btn-light text-primary border-0 rounded px-2 btn-editar-sede" 
                                            data-toggle="modal" 
                                            data-target="#modalEditarSede" 
                                            data-id="{{ $sede->id }}"
                                            data-nombre="{{ $sede->nombre }}"
                                            data-ente="{{ $sede->ente_id }}"
                                            data-direccion="{{ $sede->direccion_texto }}"
                                            title="Editar">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">
                                    No se encontraron sedes con los criterios ingresados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación Server-Side -->
        @if($sedes->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                {{ $sedes->links() }}
            </div>
        @endif

    </div>

</div>

@include('sedes.modals')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Enfoque inicial en el buscador de sedes
        if ($('#inputSearchSede').val() === '') {
            $('#inputSearchSede').focus();
        }

        // Llenar Modal Único de Edición de Sede
        $(document).on('click', '.btn-editar-sede', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let enteId = $(this).data('ente');
            let direccion = $(this).data('direccion');

            let actionUrl = "{{ route('sedes.update', ':id') }}".replace(':id', id);
            $('#formEditarSede').attr('action', actionUrl);
            $('#edit_nombre_sede').val(nombre);
            $('#edit_direccion_texto').val(direccion);

            // Asignar ente al select
            if ($('#edit_ente_id')[0].tomselect) {
                $('#edit_ente_id')[0].tomselect.setValue(enteId);
            } else {
                $('#edit_ente_id').val(enteId);
            }
        });

        // SweetAlert2: Switch de Estatus
        $(document).on('change', '.btn-confirm-switch-sede', function(e) {
            let checkbox = $(this);
            let form = checkbox.closest('form');
            let isChecking = checkbox.is(':checked');
            let nombreSede = checkbox.data('nombre');

            checkbox.prop('checked', !isChecking);

            Swal.fire({
                title: '¿Cambiar estatus?',
                text: `La sede "${nombreSede}" pasará a estar ${isChecking ? 'ACTIVA' : 'INACTIVA'}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    checkbox.prop('checked', isChecking);
                    form.submit();
                }
            });
        });

        // SweetAlert2: Guardar Modificación
        $(document).on('submit', '#formEditarSede', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: '¿Guardar modificaciones?',
                text: 'Se actualizarán los datos de la sede.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush