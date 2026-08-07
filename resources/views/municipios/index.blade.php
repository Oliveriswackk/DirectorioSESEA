@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Municipios</h1>
            <p class="text-muted small mb-0">Gestión de municipios registrados</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearMunicipio">
            <i class="fas fa-plus fa-xs mr-1"></i> Nuevo Municipio
        </button>
    </div>

    <!-- Tarjeta con Filtros y Tabla -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        
        <!-- Barra de Filtros con TomSelect -->
        <div class="card-header bg-white py-3 border-0">
            <form id="formFiltroMunicipio" action="{{ route('municipios.index') }}" method="GET" class="form-row align-items-center justify-content-between">
                
                <!-- Buscador de Estado con TomSelect -->
                <div class="col-12 col-md-5 mb-2 mb-md-0">
                    <div class="d-flex align-items-center">
                        <label for="selectEstado" class="small text-muted font-weight-bold mr-2 mb-0">Estado:</label>
                        <div class="flex-grow-1">
                            <select id="selectEstado" name="estado_id" class="select-search" onchange="document.getElementById('formFiltroMunicipio').submit()">
                                <option value="">-- Todos los Estados --</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ $estado_id == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buscador por Nombre de Municipio -->
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" id="inputSearch" class="form-control bg-light border-0 small" 
                               placeholder="Buscar municipio (Enter)..." value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-search fa-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- Tabla (15 resultados paginados) -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="border-top-0 pl-4 py-3" style="width: 45%;">Nombre</th>
                            <th class="border-top-0 py-3" style="width: 25%;">Estado</th>
                            <th class="border-top-0 text-center py-3" style="width: 15%;">Estatus</th>
                            <th class="border-top-0 text-right pr-4 py-3" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($municipios as $municipio)
                            <tr>
                                <td class="align-middle pl-4 font-weight-bold text-dark">
                                    {{ $municipio->nombre }}
                                </td>
                                <td class="align-middle text-muted">
                                    {{ $municipio->estado->nombre ?? 'N/A' }}
                                </td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('municipios.toggle', $municipio) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="custom-control custom-switch d-inline-block">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="switch-mun-{{ $municipio->id }}" 
                                                   onchange="this.form.submit()" 
                                                   {{ $municipio->activo ? 'checked' : '' }}>
                                            <label class="custom-control-label small {{ $municipio->activo ? 'text-success font-weight-bold' : 'text-muted' }}" 
                                                   for="switch-mun-{{ $municipio->id }}" style="cursor: pointer;">
                                                {{ $municipio->activo ? 'Activo' : 'Inactivo' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle text-right pr-4">
                                    <button type="button" 
                                            class="btn btn-sm btn-light text-primary border-0 rounded px-2" 
                                            data-toggle="modal" 
                                            data-target="#modalEditarMunicipio{{ $municipio->id }}" 
                                            title="Editar">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">
                                    No se encontraron municipios con los criterios seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($municipios->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                {{ $municipios->links() }}
            </div>
        @endif

    </div>

</div>

@include('municipios.modals')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Enfoque inicial en el buscador de municipios
        if ($('#inputSearch').val() === '') {
            $('#inputSearch').focus();
        }
    });
</script>
@endpush