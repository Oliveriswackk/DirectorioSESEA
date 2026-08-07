@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Entes</h1>
            <p class="text-muted small mb-0">Gestión de entes e instituciones registradas</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearEnte">
            <i class="fas fa-plus fa-xs mr-1"></i> Nuevo Ente
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
                       id="inputBuscadorEnte" 
                       class="form-control border-0 bg-transparent shadow-none" 
                       placeholder="Escribe para buscar un ente por nombre, siglas, nivel o municipio..." 
                       autofocus>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Tabla -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tablaEntes" style="width:100%;">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="border-top-0 pl-3 py-3" style="width: 40%;">Nombre / Siglas</th>
                            <th class="border-top-0 py-3" style="width: 30%;">Nivel / Municipio</th>
                            <th class="border-top-0 text-center py-3" style="width: 15%;">Estatus</th>
                            <th class="border-top-0 text-right pr-3 py-3" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($entes as $ente)
                            <tr>
                                <!-- Columna 1: Nombre y Siglas -->
                                <td class="align-middle pl-3">
                                    <div class="d-flex align-items-center">
                                        <span class="font-weight-bold text-dark mr-2">{{ $ente->nombre }}</span>
                                        @if(isset($ente->sedes_count) && $ente->sedes_count > 0)
                                            <span class="badge badge-light border text-muted px-2 py-1 font-weight-normal" title="{{ $ente->sedes_count }} sede(s) registrada(s)">
                                                <i class="fas fa-building fa-xs mr-1 text-secondary"></i>{{ $ente->sedes_count }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($ente->siglas)
                                        <small class="text-muted d-block">{{ $ente->siglas }}</small>
                                    @endif
                                </td>

                                <!-- Columna 2: Nivel y Municipio -->
                                <td class="align-middle">
                                    <div class="font-weight-bold text-gray-800">
                                        {{ $ente->nivelGobierno->nombre ?? 'Sin Nivel' }}
                                    </div>
                                    <small class="text-muted">
                                        @if($ente->municipio)
                                            <i class="fas fa-map-marker-alt fa-xs mr-1"></i>{{ $ente->municipio->nombre }}
                                            @if($ente->municipio->estado)
                                                ({{ $ente->municipio->estado->nombre }})
                                            @endif
                                        @else
                                            <span class="text-black-50">Sin municipio</span>
                                        @endif
                                    </small>
                                </td>

                                <!-- Columna 3: Switch de Estatus -->
                                <td class="align-middle text-center">
                                    <form action="{{ route('entes.toggle', $ente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="custom-control custom-switch d-inline-block">
                                            <input type="checkbox" 
                                                   class="custom-control-input btn-confirm-switch" 
                                                   id="switch-ente-{{ $ente->id }}" 
                                                   {{ $ente->activo ? 'checked' : '' }}>
                                            <label class="custom-control-label small {{ $ente->activo ? 'text-success font-weight-bold' : 'text-muted' }}" 
                                                   for="switch-ente-{{ $ente->id }}" style="cursor: pointer;">
                                                {{ $ente->activo ? 'Activo' : 'Inactivo' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>

                                <!-- Columna 4: Acciones (Ver Sedes + Editar) -->
                                <td class="align-middle text-right pr-3">
                                    <div class="btn-group" role="group">
                                        <!-- Ver Sedes (Botón sutil de icono, sin texto que robe espacio) -->
                                        <a href="{{ route('sedes.index', ['ente_id' => $ente->id]) }}" 
                                        class="btn btn-sm btn-light text-secondary border-0 rounded mr-1 px-2" 
                                        title="Ver sedes de {{ $ente->nombre }}">
                                            <i class="fas fa-building fa-xs"></i>
                                        </a>

                                        <!-- Botón Editar (Conserva el protagonismo principal) -->
                                        <button type="button" 
                                                class="btn btn-sm btn-light text-primary border-0 rounded px-2 btn-editar-ente" 
                                                data-toggle="modal" 
                                                data-target="#modalEditarEnte" 
                                                data-id="{{ $ente->id }}"
                                                data-nombre="{{ $ente->nombre }}"
                                                data-siglas="{{ $ente->siglas }}"
                                                data-nivel="{{ $ente->nivel_gobierno_id }}"
                                                data-municipio="{{ $ente->municipio_id }}"
                                                title="Editar Ente">
                                            <i class="fas fa-pen fa-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@include('entes.modals')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicialización optimizada de DataTables
        if ($.fn.DataTable) {
            var table = $('#tablaEntes').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                dom: 'rtip', // Oculta el buscador por defecto de DataTables para usar nuestra barra dedicada
                pageLength: 15,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [2, 3] }
                ]
            });

            // Conexión del Input Personalizado con Autofocus a DataTables
            var $buscador = $('#inputBuscadorEnte');
            $buscador.focus();
            
            $buscador.on('keyup search input', function() {
                table.search(this.value).draw();
            });
        }

        // Llenar el Modal Único de Edición al hacer clic en el lápiz
        $(document).on('click', '.btn-editar-ente', function() {
            let id = $(this).data('id');
            let nombre = $(this).data('nombre');
            let siglas = $(this).data('siglas');
            let nivel = $(this).data('nivel');
            let municipio = $(this).data('municipio');

            // Configura la acción del formulario dinámicamente
            let formUrl = "{{ route('entes.update', ':id') }}".replace(':id', id);
            $('#formEditarEnte').attr('action', formUrl);

            // Asigna los valores a los inputs
            $('#edit_nombre').val(nombre);
            $('#edit_siglas').val(siglas);

            // Asigna valores a TomSelect en el modal
            if ($('#edit_nivel_gobierno_id')[0].tomselect) {
                $('#edit_nivel_gobierno_id')[0].tomselect.setValue(nivel);
            } else {
                $('#edit_nivel_gobierno_id').val(nivel);
            }

            if ($('#edit_municipio_id')[0].tomselect) {
                $('#edit_municipio_id')[0].tomselect.setValue(municipio || '');
            } else {
                $('#edit_municipio_id').val(municipio || '');
            }
        });

        // Switch de Confirmación con SweetAlert2
        $(document).on('change', '.btn-confirm-switch', function(e) {
            let checkbox = $(this);
            let form = checkbox.closest('form');
            let isChecking = checkbox.is(':checked');

            checkbox.prop('checked', !isChecking);

            Swal.fire({
                title: '¿Cambiar estatus?',
                text: `El ente pasará a estar ${isChecking ? 'ACTIVO' : 'INACTIVO'}.`,
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

        // Confirmación SweetAlert2 antes de actualizar un Ente
        $(document).on('submit', '#formEditarEnte', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: '¿Guardar modificaciones?',
                text: 'Se actualizarán los datos del ente en el sistema.',
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