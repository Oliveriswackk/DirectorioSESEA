@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Estados</h1>
            <p class="text-muted small mb-0">Gestión de estados registrados</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearEstado">
            <i class="fas fa-plus fa-xs mr-1"></i> Nuevo Estado
        </button>
    </div>

    <!-- Barra de Búsqueda Personalizada con Autofocus -->
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="card-body p-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <input type="text" 
                       id="inputBuscadorEstado" 
                       class="form-control border-0 bg-transparent shadow-none" 
                       placeholder="Escribe para buscar un estado..." 
                       autofocus>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Tabla -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tablaEstados" style="width:100%;">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="border-top-0 pl-3 py-3" style="width: 70%;">Nombre</th>
                            <th class="border-top-0 text-center py-3" style="width: 15%;">Estatus</th>
                            <th class="border-top-0 text-right pr-3 py-3" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($estados as $estado)
                            <tr>
                                <td class="align-middle font-weight-bold text-dark pl-3">
                                    {{ $estado->nombre }}
                                </td>
                                
                                <!-- Estatus con Switch Confirm -->
                                <td class="align-middle text-center">
                                    <form action="{{ route('estados.toggle', $estado) }}" method="POST" class="d-inline form-toggle-estatus">
                                        @csrf
                                        @method('PATCH')
                                        <div class="custom-control custom-switch d-inline-block">
                                            <input type="checkbox" 
                                                   class="custom-control-input btn-switch-confirm" 
                                                   id="switch-{{ $estado->id }}" 
                                                   data-nombre="{{ $estado->nombre }}"
                                                   {{ $estado->activo ? 'checked' : '' }}>
                                            <label class="custom-control-label small {{ $estado->activo ? 'text-success font-weight-bold' : 'text-muted' }}" 
                                                   for="switch-{{ $estado->id }}" style="cursor: pointer;">
                                                {{ $estado->activo ? 'Activo' : 'Inactivo' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>

                                <!-- Botón Editar (Lápiz) -->
                                <td class="align-middle text-right pr-3">
                                    <button type="button" 
                                            class="btn btn-sm btn-light text-primary border-0 rounded px-2 btn-editar-estado" 
                                            data-toggle="modal" 
                                            data-target="#modalEditarEstado" 
                                            data-id="{{ $estado->id }}"
                                            data-nombre="{{ $estado->nombre }}"
                                            title="Editar">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@include('estados.modals')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        
        // 1. Inicialización de DataTables con Barra Personalizada
        if ($.fn.DataTable) {
            var table = $('#tablaEstados').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                dom: 'rtip', // Oculta la barra nativa de DataTables
                pageLength: 10,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [1, 2] }
                ]
            });

            // Dar autofocus al buscador personalizado y conectar con DataTables
            var $buscador = $('#inputBuscadorEstado');
            $buscador.focus();

            $buscador.on('keyup search input', function() {
                table.search(this.value).draw();
            });
        }


        // 2. Llenar el Modal Único de Edición al hacer clic en el Lápiz
        $(document).on('click', '.btn-editar-estado', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');

            let actionUrl = "{{ route('estados.update', ':id') }}".replace(':id', id);
            $('#formEditarEstado').attr('action', actionUrl);
            $('#edit_nombre_estado').val(nombre);
        });


        // 3. SweetAlert2: Confirmación de cambio de Estatus (Switch)
        $(document).on('change', '.btn-switch-confirm', function(e) {
            let checkbox = $(this);
            let form = checkbox.closest('form');
            let isChecking = checkbox.is(':checked');
            let nombreEstado = checkbox.data('nombre');

            // Previene el cambio visual inmediato hasta confirmar
            checkbox.prop('checked', !isChecking);

            Swal.fire({
                title: '¿Cambiar estatus?',
                text: `El estado "${nombreEstado}" pasará a estar ${isChecking ? 'ACTIVO' : 'INACTIVO'}.`,
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


        // 4. SweetAlert2: Confirmación antes de Guardar Cambios en Edición
        $(document).on('submit', '#formEditarEstado', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: '¿Guardar modificaciones?',
                text: 'Se actualizarán los datos del estado en el sistema.',
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