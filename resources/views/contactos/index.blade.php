@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Directorio de Contactos</h1>
            <p class="text-muted small mb-0">Gestión de servidores públicos y personal registrado</p>
        </div>
        
        <!-- Botones de Cambio de Vista y Nuevo Contacto -->
        <div class="d-flex align-items-center">
            <div class="btn-group btn-group-sm shadow-sm mr-2" role="group">
                <button type="button" id="btnVistaTabla" class="btn btn-primary active" onclick="cambiarVista('tabla')">
                    <i class="fas fa-table mr-1"></i> Tabla
                </button>
                <button type="button" id="btnVistaCards" class="btn btn-light border" onclick="cambiarVista('cards')">
                    <i class="fas fa-th-large mr-1"></i> Tarjetas
                </button>
            </div>

            <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearContacto">
                <i class="fas fa-user-plus fa-xs mr-1"></i> Nuevo Contacto
            </button>
        </div>
    </div>

    <!-- BARRA DE BÚSQUEDA, FILTROS Y ACCIONES -->
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <!-- Buscador -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <div class="input-group bg-light rounded border">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 text-muted"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="inputBuscadorGlobal" class="form-control form-control-sm border-0 bg-transparent shadow-none" placeholder="Buscar...">
                    </div>
                </div>

                <!-- Filtro Nivel -->
                <div class="col-md-2 mb-2 mb-md-0 px-1">
                    <select id="filtroNivelGobierno" class="form-control form-control-sm border bg-light select-search">
                        <option value="">Nivel Gobierno...</option>
                        @if(isset($nivelesGobierno))
                            @foreach($nivelesGobierno as $nivel)
                                <option value="{{ $nivel->nombre }}">{{ $nivel->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Filtro Ente -->
                <div class="col-md-2 mb-2 mb-md-0 px-1">
                    <select id="filtroEnte" class="form-control form-control-sm border bg-light select-search">
                        <option value="">Ente...</option>
                        @if(isset($entes))
                            @foreach($entes as $ente)
                                <option value="{{ $ente->nombre }}">{{ $ente->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Filtro Puesto -->
                <div class="col-md-2 mb-2 mb-md-0 px-1">
                    <select id="filtroPuesto" class="form-control form-control-sm border bg-light select-search">
                        <option value="">Puesto...</option>
                        @if(isset($puestos))
                            @foreach($puestos as $puesto)
                                <option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Botones de Acción (Filtrar, Limpiar, Exportar) -->
                <div class="col-md-3 text-right">
                    <button type="button" class="btn btn-primary btn-sm px-2" onclick="aplicarFiltrosGlobales()" title="Filtrar">
                        <i class="fas fa-filter fa-xs"></i>
                    </button>
                    <button type="button" class="btn btn-light border btn-sm px-2 text-secondary" onclick="limpiarFiltros()" title="Limpiar filtros">
                        <i class="fas fa-eraser fa-xs"></i>
                    </button>
                    <div class="dropdown d-inline-block ml-1">
                        <button class="btn btn-success btn-sm dropdown-toggle px-2" type="button" id="dropdownExportar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Exportar">
                            <i class="fas fa-file-excel fa-xs"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 small" aria-labelledby="dropdownExportar">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success mr-1"></i> Exportar a Excel</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-file-pdf text-danger mr-1"></i> Exportar a PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENEDOR DINÁMICO DE VISTAS -->
    <div idSeccion="seccionTabla">
        @include('contactos.partials.tabla-view')
    </div>

    <div idSeccion="seccionCards" style="display: none;">
        @include('contactos.partials.cards-view')
    </div>

</div>

<!-- CAJÓN LATERAL (INSPECTOR) -->
<div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="inspectorLateral" aria-labelledby="inspectorLabel" style="width: 450px; background: #fff; position: fixed; top: 0; right: -450px; height: 100vh; z-index: 1050; transition: right 0.3s ease;">
    <div class="offcanvas-header bg-light border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
        <h5 class="offcanvas-title font-weight-bold text-dark mb-0" id="inspectorLabel">Detalle de Vinculación</h5>
        <button type="button" class="close border-0 bg-transparent text-dark" data-dismiss="offcanvas" aria-label="Close" onclick="cerrarInspector()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="offcanvas-body px-4 py-3 overflow-auto" style="height: calc(100vh - 70px);">
        <form id="formEditarInspector" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Nombre(s) *</label>
                <input type="text" id="insp_nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Apellido Paterno</label>
                <input type="text" id="insp_apellido_paterno" name="apellido_paterno" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Apellido Materno</label>
                <input type="text" id="insp_apellido_materno" name="apellido_materno" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Puesto *</label>
                <select id="insp_puesto_id" name="puesto_id" class="form-control select-search" required>
                    <option value="">Seleccione...</option>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Ente / Institución *</label>
                <select id="insp_ente_id" name="ente_id" class="form-control select-search" required>
                    <option value="">Seleccione...</option>
                    @foreach($entes as $ente)
                        <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Sede</label>
                <select id="insp_sede_id" name="sede_id" class="form-control select-search">
                    <option value="">Ninguna...</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="small font-weight-bold text-muted">Correo</label>
                <input type="email" id="insp_correo" name="correo" class="form-control">
            </div>
            <div class="form-row mb-3">
                <div class="col-8">
                    <label class="small font-weight-bold text-muted">Teléfono</label>
                    <input type="text" id="insp_telefono" name="telefono" class="form-control">
                </div>
                <div class="col-4">
                    <label class="small font-weight-bold text-muted">Ext.</label>
                    <input type="text" id="insp_extension" name="extension" class="form-control">
                </div>
            </div>

            <div class="border-top pt-3 text-right">
                <button type="button" class="btn btn-secondary btn-sm" onclick="cerrarInspector()">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-sm">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

@include('contactos.modals')
@endsection

@push('scripts')
<script>
    let vistaActual = 'tabla';

    function cambiarVista(tipo) {
        vistaActual = tipo;
        const tabla = document.querySelector('[idSeccion="seccionTabla"]');
        const cards = document.querySelector('[idSeccion="seccionCards"]');
        const btnTabla = document.getElementById('btnVistaTabla');
        const btnCards = document.getElementById('btnVistaCards');

        if (tipo === 'tabla') {
            tabla.style.display = 'block';
            cards.style.display = 'none';
            btnTabla.classList.add('btn-primary', 'active');
            btnTabla.classList.remove('btn-light', 'border');
            btnCards.classList.remove('btn-primary', 'active');
            btnCards.classList.add('btn-light', 'border');
        } else {
            tabla.style.display = 'none';
            cards.style.display = 'block';
            btnCards.classList.add('btn-primary', 'active');
            btnCards.classList.remove('btn-light', 'border');
            btnTabla.classList.remove('btn-primary', 'active');
            btnTabla.classList.add('btn-light', 'border');
        }
        aplicarFiltrosGlobales();
    }

    function abrirInspector(el) {
        let id = el.getAttribute('data-id');
        let formUrl = "{{ route('contactos.update', ':id') }}".replace(':id', id);
        document.getElementById('formEditarInspector').setAttribute('action', formUrl);

        document.getElementById('insp_nombre').value = el.getAttribute('data-nombre') || '';
        document.getElementById('insp_apellido_paterno').value = el.getAttribute('data-apellido_paterno') || '';
        document.getElementById('insp_apellido_materno').value = el.getAttribute('data-apellido_materno') || '';
        document.getElementById('insp_puesto_id').value = el.getAttribute('data-puesto') || '';
        document.getElementById('insp_ente_id').value = el.getAttribute('data-ente') || '';
        document.getElementById('insp_sede_id').value = el.getAttribute('data-sede') || '';
        document.getElementById('insp_correo').value = el.getAttribute('data-correo') || '';
        document.getElementById('insp_telefono').value = el.getAttribute('data-telefono') || '';
        document.getElementById('insp_extension').value = el.getAttribute('data-extension') || '';

        document.getElementById('inspectorLateral').style.right = '0';
    }

    function cerrarInspector() {
        document.getElementById('inspectorLateral').style.right = '-450px';
    }

    function aplicarFiltrosGlobales() {
        let textoBusqueda = $('#inputBuscadorGlobal').val().toLowerCase().trim();
        let nivelFiltro = $('#filtroNivelGobierno').val().toLowerCase();
        let enteFiltro = $('#filtroEnte').val().toLowerCase();
        let puestoFiltro = $('#filtroPuesto').val().toLowerCase();

        if (vistaActual === 'tabla') {
            if (window.tablaContactosDT) {
                window.tablaContactosDT.search(textoBusqueda);
                window.tablaContactosDT.column(1).search(enteFiltro ? '^' + enteFiltro + '$' : '', true, false);
                window.tablaContactosDT.column(0).search(puestoFiltro ? puestoFiltro : '', true, false);
                window.tablaContactosDT.draw();
            }
        } else {
            $('#contenedorCards .contacto-card-item').each(function() {
                let cardText = $(this).text().toLowerCase();
                let cardNivel = ($(this).data('nivel') || '').toLowerCase();
                let cardEnte = ($(this).data('ente') || '').toLowerCase();
                let cardPuesto = ($(this).data('puesto') || '').toLowerCase();

                let coincideTexto = textoBusqueda === '' || cardText.includes(textoBusqueda);
                let coincideNivel = nivelFiltro === '' || cardNivel.includes(nivelFiltro);
                let coincideEnte = enteFiltro === '' || cardEnte.includes(enteFiltro);
                let coincidePuesto = puestoFiltro === '' || cardPuesto.includes(puestoFiltro);

                if (coincideTexto && coincideNivel && coincideEnte && coincidePuesto) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    }

    function limpiarFiltros() {
        $('#inputBuscadorGlobal').val('');
        $('#filtroNivelGobierno').val('');
        $('#filtroEnte').val('');
        $('#filtroPuesto').val('');
        aplicarFiltrosGlobales();
    }

    $(document).ready(function() {
        if ($.fn.DataTable) {
            window.tablaContactosDT = $('#tablaContactos').DataTable({
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
                dom: 'rtip',
                pageLength: 15,
                responsive: true,
                columnDefs: [{ orderable: false, targets: [4] }]
            });
        }

        $('#inputBuscadorGlobal').on('keyup', function() {
            aplicarFiltrosGlobales();
        });

        $(document).on('click', '.btn-nota-contacto', function(e) {
            e.stopPropagation();
            let id = $(this).data('id');
            let formUrl = "{{ route('contactos.update-nota', ':id') }}".replace(':id', id);
            $('#formNotaContacto').attr('action', formUrl);
            $('#labelNombreNota').text($(this).data('nombre'));
            $('#nota_observaciones').val($(this).data('observaciones'));
            $('#modalNotaContacto').modal('show');
        });
    });
</script>
@endpush