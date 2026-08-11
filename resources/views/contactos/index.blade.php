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

    <!-- PANEL DE CONTROL Y FILTROS -->
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="card-body p-3">
            
            <!-- Fila 1: Buscador Global con estilo de barra grande -->
            <div class="mb-3">
                <div class="card border-0 shadow-sm rounded-lg bg-light">
                    <div class="card-body p-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0 text-muted">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" 
                                id="inputBuscadorGlobal" 
                                class="form-control border-0 bg-transparent shadow-none" 
                                placeholder="Escribe para buscar un contacto de manera global..." 
                                autofocus>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fila 2: Selects de Filtros (Nivel, Ente, Puesto y Estado Activo) -->
            <div class="row align-items-center mb-3">
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroNivelGobierno" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Nivel Gobierno...</option>
                        @foreach($nivelesGobierno as $nivel)<option value="{{ $nivel->nombre }}">{{ $nivel->nombre }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroEnte" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Ente...</option>
                        @foreach($entes as $ente)<option value="{{ $ente->nombre }}">{{ $ente->nombre }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroPuesto" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Puesto...</option>
                        @foreach($puestos as $puesto)<option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroEstado" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Estado (Todos)...</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>
            </div>

            <!-- Fila 3: Botones de Acción (Añadir, Limpiar y Exportar) -->
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalCrearContacto">
                        <i class="fas fa-plus mr-1"></i> Añadir Contacto
                    </button>
                    <button type="button" class="btn btn-light border btn-sm text-secondary" onclick="limpiarFiltros()" title="Limpiar filtros">
                        <i class="fas fa-eraser mr-1"></i> Limpiar filtros
                    </button>
                </div>
                <div>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownExportar" data-toggle="dropdown">
                            <i class="fas fa-file-excel mr-1"></i> Exportar
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 small">
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

        // Datos básicos de texto
        document.getElementById('insp_nombre').value = el.getAttribute('data-nombre') || '';
        document.getElementById('insp_apellido_paterno').value = el.getAttribute('data-apellido_paterno') || '';
        document.getElementById('insp_apellido_materno').value = el.getAttribute('data-apellido_materno') || '';
        
        document.getElementById('insp_correo').value = el.getAttribute('data-correo') || '';
        document.getElementById('insp_telefono').value = el.getAttribute('data-telefono') || '';
        document.getElementById('insp_extension').value = el.getAttribute('data-extension') || '';

        // Asignación correcta de valores para Selects (Soportando librerías como TomSelect / Select2)
        let puestoId = el.getAttribute('data-puesto-id') || '';
        let enteId = el.getAttribute('data-ente-id') || '';
        let sedeId = el.getAttribute('data-sede-id') || '';

        // 1. Puesto
        let selectPuesto = document.getElementById('insp_puesto_id');
        selectPuesto.value = puestoId;
        if (selectPuesto.tomselect) {
            selectPuesto.tomselect.setValue(puestoId);
        } else if ($(selectPuesto).hasClass('select2-hidden-accessible')) {
            $(selectPuesto).val(puestoId).trigger('change');
        }

        // 2. Ente
        let selectEnte = document.getElementById('insp_ente_id');
        selectEnte.value = enteId;
        if (selectEnte.tomselect) {
            selectEnte.tomselect.setValue(enteId);
        } else if ($(selectEnte).hasClass('select2-hidden-accessible')) {
            $(selectEnte).val(enteId).trigger('change');
        }

        // 3. Sede
        let selectSede = document.getElementById('insp_sede_id');
        selectSede.value = sedeId;
        if (selectSede.tomselect) {
            selectSede.tomselect.setValue(sedeId);
        } else if ($(selectSede).hasClass('select2-hidden-accessible')) {
            $(selectSede).val(sedeId).trigger('change');
        }

        // Mostrar el cajón lateral deslizándolo
        document.getElementById('inspectorLateral').style.right = '0';
    }

    function cerrarInspector() {
        document.getElementById('inspectorLateral').style.right = '-450px';
    }

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function aplicarFiltrosGlobales() {
        let textoBusqueda = $('#inputBuscadorGlobal').val().toLowerCase().trim();
        let nivelFiltro = $('#filtroNivelGobierno').val();
        let enteFiltro = $('#filtroEnte').val();
        let puestoFiltro = $('#filtroPuesto').val();
        let estadoFiltro = $('#filtroEstado').val();

        if (vistaActual === 'tabla') {
            if (window.tablaContactosDT) {
                window.tablaContactosDT.search(textoBusqueda);
                
                window.tablaContactosDT.column(1).search(nivelFiltro, true, false);
                window.tablaContactosDT.column(2).search(enteFiltro, true, false);
                window.tablaContactosDT.column(3).search(puestoFiltro, true, false);
                window.tablaContactosDT.column(4).search(estadoFiltro === '1' ? 'Activo' : (estadoFiltro === '0' ? 'Inactivo' : ''), true, false);

                window.tablaContactosDT.draw();
            }
        } else {
            $('#contenedorCards .contacto-card-item').each(function() {
                let text = $(this).text().toLowerCase();
                let match = text.includes(textoBusqueda) && 
                            ($(this).data('nivel') == nivelFiltro || !nivelFiltro) &&
                            ($(this).data('ente') == enteFiltro || !enteFiltro) &&
                            ($(this).data('puesto') == puestoFiltro || !puestoFiltro) &&
                            ($(this).data('estado') == estadoFiltro || estadoFiltro === '');
                $(this).toggle(match);
            });
        }
    }

    function limpiarFiltros() {
        $('#inputBuscadorGlobal').val('');
        $('.filter-trigger').each(function() {
            if (this.tomselect) {
                this.tomselect.clear();
            } else {
                $(this).val('');
            }
        });
        aplicarFiltrosGlobales();
    }

    $(document).ready(function() {
        if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tablaContactos')) {
            window.tablaContactosDT = $('#tablaContactos').DataTable({
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
                dom: 'rtip',
                pageLength: 15,
                responsive: true,
                columnDefs: [{ orderable: false, targets: [-1] }]
            });
        }

        $(document).on('change', '.filter-trigger', function() {
            aplicarFiltrosGlobales();
        });

        $('#inputBuscadorGlobal').on('keyup', debounce(function() {
            aplicarFiltrosGlobales();
        }, 300));
    });
</script>
@endpush