@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Estados</h1>
            <p class="text-muted small mb-0">Gestión e inventario de estados registrados</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearEstado">
            <i class="fas fa-plus fa-xs mr-1"></i> Nuevo Estado
        </button>
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
                                <td class="align-middle text-center">
                                    <form action="{{ route('estados.toggle', $estado) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="custom-control custom-switch d-inline-block">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="switch-{{ $estado->id }}" 
                                                   onchange="this.form.submit()" 
                                                   {{ $estado->activo ? 'checked' : '' }}>
                                            <label class="custom-control-label small {{ $estado->activo ? 'text-success font-weight-bold' : 'text-muted' }}" 
                                                   for="switch-{{ $estado->id }}" style="cursor: pointer;">
                                                {{ $estado->activo ? 'Activo' : 'Inactivo' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle text-right pr-3">
                                    <button type="button" 
                                            class="btn btn-sm btn-light text-primary border-0 rounded px-2" 
                                            data-toggle="modal" 
                                            data-target="#modalEditarEstado{{ $estado->id }}" 
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
        if ($.fn.DataTable) {
            var table = $('#tablaEstados').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [1, 2] }
                ]
            });

            // Dar foco automático al buscador de DataTables
            setTimeout(function() {
                $('#tablaEstados_filter input').focus();
            }, 100);
        } else {
            console.error('DataTables no está cargado correctamente.');
        }
    });
</script>
@endpush