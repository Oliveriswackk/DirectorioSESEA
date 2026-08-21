@extends('layouts.app')

@section('content')
<style>
    /* Inspector CSS */
    .inspector-tab {
        position: relative;
        border: 0;
        background: transparent;
        padding: .55rem 0 .65rem;
        margin: 0;
        color: #858796;
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        outline: none !important;
        box-shadow: none !important;
    }

    .inspector-tab::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: .3rem;
        height: 2px;
        background: transparent;
        border-radius: 2px;
        transition: background-color .2s ease;
    }

    .inspector-tab:hover {
        color: #4e73df;
    }

    .inspector-tab.active {
        color: #4e73df;
    }

    .inspector-tab.active::after {
        background: #4e73df;
    }

    .inspector-tab:focus,
    .inspector-tab:active {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Alerta CSS */
    .text-revision {
        color: #daa20a !important;
    }
</style>
<div class="container-fluid px-4">

    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 mb-0 font-weight-bold text-gray-800">Directorio de Contactos</h1>
            <p class="text-muted small mb-0">Gestión de servidores públicos y personal registrado</p>
        </div>
        
        <!-- Botones de Cambio de Vista (Tabla/Cards)
        <div class="d-flex align-items-center">
            <div class="btn-group btn-group-sm shadow-sm mr-2" role="group">
                <button type="button" id="btnVistaTabla" class="btn btn-primary active" onclick="cambiarVista('tabla')">
                    <i class="fas fa-table mr-1"></i> Tabla
                </button>
                <button type="button" id="btnVistaCards" class="btn btn-light border" onclick="cambiarVista('cards')">
                    <i class="fas fa-th-large mr-1"></i> Tarjetas
                </button>
            </div>
        </div>
        -->
    </div>

    <!-- PANEL DE CONTROL Y FILTROS -->
    <div class="card border-0 shadow-sm rounded-lg mb-3">
        <div class="card-body p-3">
            
            <!-- Fila 1: Buscador Global -->
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

            <!-- Fila 2: Selects de Filtros -->
            <div class="row align-items-center mb-3">
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroNivelGobierno" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Nivel Gobierno...</option>
                        @foreach($nivelesGobierno as $nivel)
                            <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroEnte" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Ente...</option>
                        @foreach($entes as $ente)
                            <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroPuesto" class="select-search form-control form-control-sm border bg-light filter-trigger">
                        <option value="">Puesto...</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0 px-1">
                    <select id="filtroRevision"
                            class="select-search form-control form-control-sm border bg-light filter-trigger">

                        <option value="">Revisión...</option>
                        <option value="requiere_revision">
                            Requiere revisión
                        </option>

                    </select>
                </div>
            </div>

            <!-- Fila 3: Botones de Acción -->
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary btn-sm rounded shadow-sm" data-toggle="modal" data-target="#modalCrearContacto">
                        <i class="fas fa-user-plus fa-xs mr-1"></i> Nuevo Contacto
                    </button>
                    <button type="button" class="btn btn-light border btn-sm text-secondary ml-2" onclick="limpiarFiltros()" title="Limpiar filtros">
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
    <div id="seccionTabla">
        @include('contactos.partials.tabla-view')
    </div>

    <div id="seccionCards" style="display: none;">
        @include('contactos.partials.cards-view')
    </div>

    <!-- BUZÓN DE INFORMACIÓN PARA SISTEMAS -->
    <div class="card border-0 shadow-sm rounded-lg mt-3 mb-4">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <div class="mr-3 text-primary">
                        <i class="fas fa-file-upload fa-lg"></i>
                    </div>

                    <div>
                        <h6 class="font-weight-bold text-gray-800 mb-1">
                            ¿Tienes varios contactos que agregar o actualizar?
                        </h6>

                        <p class="small text-muted mb-0">
                            Envíalos a Sistemas para su revisión y carga.
                        </p>
                    </div>

                </div>

                <div class="ml-3">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm rounded shadow-sm"
                        data-toggle="modal"
                        data-target="#modalEnviarInformacion">

                        <i class="fas fa-paper-plane fa-xs mr-1"></i>
                        Enviar información
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- LLAMADO ÚNICO DE MODALES EXTERNOS -->
@include('contactos.modals')

@endsection

@push('scripts')
<script>

    let vistaActual = 'tabla';

    const CARDS_POR_PAGINA = 12;

    let paginaCardsActual = 1;


    // =========================================================
    // CAMBIO DE VISTA
    // =========================================================

    function cambiarVista(tipo) {

        vistaActual = tipo;

        const tabla = document.getElementById('seccionTabla');
        const cards = document.getElementById('seccionCards');

        const btnTabla = document.getElementById('btnVistaTabla');
        const btnCards = document.getElementById('btnVistaCards');

        if (tipo === 'tabla') {

            tabla.style.display = 'block';
            cards.style.display = 'none';

            btnTabla.classList.add('btn-primary', 'active');
            btnTabla.classList.remove('btn-light', 'border');

            btnCards.classList.remove('btn-primary', 'active');
            btnCards.classList.add('btn-light', 'border');

            if (window.tablaContactosDT) {
                window.tablaContactosDT
                    .columns
                    .adjust()
                    .responsive
                    .recalc();
            }

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


    // =========================================================
    // INSPECTOR — ABRIR
    // =========================================================
    function abrirInspector(el) {

        const id = el.getAttribute('data-id');

        const formUrl =
            "{{ route('contactos.update', ':id') }}"
                .replace(':id', id);

        const formulario =
            document.getElementById('formEditarInspector');

        formulario.setAttribute('action', formUrl);


        // =====================================================
        // DATOS PERSONALES
        // =====================================================

        const nombre =
            el.getAttribute('data-nombre') || '';

        const apellidoPaterno =
            el.getAttribute('data-apellido_paterno') || '';

        const apellidoMaterno =
            el.getAttribute('data-apellido_materno') || '';

        document.getElementById('insp_nombre').value =
            nombre;

        document.getElementById('insp_apellido_paterno').value =
            apellidoPaterno;

        document.getElementById('insp_apellido_materno_input').value =
            apellidoMaterno;


        // =====================================================
        // NOMBRE VISIBLE
        // =====================================================

        const nombreCompleto = [
            nombre,
            apellidoPaterno,
            apellidoMaterno
        ]
            .filter(Boolean)
            .join(' ');

        document.getElementById('insp_nombre_display').textContent =
            nombreCompleto || 'Detalles del contacto';


        // =====================================================
        // ESTADO
        // =====================================================

        const activo =
            el.getAttribute('data-activo') === '1';

        const badge =
            document.getElementById('insp_estado_badge');

        if (activo) {

            badge.textContent = 'ACTIVO';

            badge.className =
                'badge badge-success mr-2';

        } else {

            badge.textContent = 'INACTIVO';

            badge.className =
                'badge badge-danger mr-2';
        }


        // =====================================================
        // DATOS DE CONTACTO
        // =====================================================

        document.getElementById('insp_correo').value =
            el.getAttribute('data-correo') || '';

        document.getElementById('insp_telefono').value =
            el.getAttribute('data-telefono') || '';

        document.getElementById('insp_extension').value =
            el.getAttribute('data-extension') || '';

        document.getElementById('insp_celular').value =
            el.getAttribute('data-celular') || '';

        document.getElementById('insp_observaciones').value =
            el.getAttribute('data-observaciones') || '';


        // =====================================================
        // INFORMACIÓN TERRITORIAL
        // =====================================================

        document.getElementById('insp_nivel').textContent =
            el.getAttribute('data-nivel') || 'No disponible';

        document.getElementById('insp_municipio').textContent =
            el.getAttribute('data-municipio') || 'No disponible';

        document.getElementById('insp_estado').textContent =
            el.getAttribute('data-estado') || 'No disponible';

        document.getElementById('insp_direccion').textContent =
            el.getAttribute('data-direccion') ||
            'Sin dirección registrada';


        // =====================================================
        // IDS DE ASIGNACIÓN
        // =====================================================

        const puestoId =
            el.getAttribute('data-puesto-id') || '';

        const enteId =
            el.getAttribute('data-ente-id') || '';

        const sedeId =
            el.getAttribute('data-sede-id') || '';


        // =====================================================
        // GUARDAR VALORES ORIGINALES
        // =====================================================

        formulario.dataset.puestoOriginal =
            puestoId;

        formulario.dataset.enteOriginal =
            enteId;


        // =====================================================
        // CARGAR TOMSELECT
        // =====================================================

        const selects = [
            ['puesto', puestoId],
            ['ente', enteId],
            ['sede', sedeId]
        ];

        selects.forEach(([campo, valor]) => {

            const select =
                document.getElementById(`insp_${campo}_id`);

            if (!select) {
                return;
            }

            if (select.tomselect) {

                select.tomselect.setValue(
                    valor || '',
                    true
                );

            } else {

                select.value =
                    valor || '';
            }

        });


        // =====================================================
        // SIEMPRE INICIAR EN INFORMACIÓN ACTUAL
        // =====================================================

        switchTabInspector('actual');


        // =====================================================
        // GUARDAR ESTADO INICIAL DEL FORMULARIO
        // =====================================================

        formulario.dataset.estadoOriginal =
            new URLSearchParams(
                new FormData(formulario)
            ).toString();


        // =====================================================
        // ABRIR INSPECTOR
        // =====================================================

        document
            .getElementById('inspectorLateral')
            .style.right = '0';
    }


    // =========================================================
    // INSPECTOR — CERRAR
    // =========================================================
    function cerrarInspector() {

        const inspector =
            document.getElementById('inspectorLateral');

        const formulario =
            document.getElementById('formEditarInspector');

        const estadoActual =
            new URLSearchParams(
                new FormData(formulario)
            ).toString();

        const estadoOriginal =
            formulario.dataset.estadoOriginal || '';

        const hayCambios =
            estadoActual !== estadoOriginal;


        // =====================================================
        // SIN CAMBIOS → CERRAR DIRECTAMENTE
        // =====================================================

        if (!hayCambios) {

            inspector.style.right = '-480px';

            return;
        }


        // =====================================================
        // HAY CAMBIOS → CONFIRMAR
        // =====================================================

        Swal.fire({

            title: 'Hay cambios sin guardar',

            text:
                'Modificaste información de este contacto. ¿Qué deseas hacer?',

            icon: 'warning',

            showDenyButton: true,
            showCancelButton: true,

            confirmButtonText: 'Guardar cambios',
            denyButtonText: 'Descartar cambios',
            cancelButtonText: 'Seguir editando',

            reverseButtons: true

        }).then((result) => {

            // =================================================
            // GUARDAR
            // =================================================

            if (result.isConfirmed) {

                formulario.requestSubmit();

                return;
            }


            // =================================================
            // DESCARTAR
            // =================================================

            if (result.isDenied) {

                inspector.style.right = '-480px';

            }

        });
    }

    // =========================================================
    // INSPECTOR — ESC
    // =========================================================

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        const inspector =
            document.getElementById('inspectorLateral');

        if (inspector.style.right === '0px') {

            cerrarInspector();

        }

    });


    // =========================================================
    // INSPECTOR — DESCARTAR Y CERRAR
    // =========================================================

    function descartarCambiosInspector() {

        document
            .getElementById('inspectorLateral')
            .style.right = '-480px';
    }

    // =========================================================
    // INSPECTOR — PESTAÑAS
    // =========================================================

    function switchTabInspector(tab) {

        const tabActual =
            document.getElementById('tabInspectorActual');

        const contenidoActual =
            document.getElementById('tabInspectorActualContenido');

        if (!tabActual || !contenidoActual) {
            console.error(
                'No se encontraron los elementos principales del inspector.'
            );
            return;
        }

        if (tab === 'actual') {

            tabActual.classList.add('active');

            contenidoActual.style.display = 'block';

            return;
        }

        console.warn(
            'Pestaña de inspector no disponible actualmente:',
            tab
        );
    }

    // =========================================================
    // FORMULARIO DEL INSPECTOR
    // =========================================================

    document
        .getElementById('formEditarInspector')
        ?.addEventListener('submit', function(event) {

            event.preventDefault();

            const form = this;

            const puestoOriginal =
                form.dataset.puestoOriginal || '';

            const enteOriginal =
                form.dataset.enteOriginal || '';

            const puestoNuevo =
                document
                    .getElementById('insp_puesto_id')
                    .value;

            const enteNuevo =
                document
                    .getElementById('insp_ente_id')
                    .value;


            const cambioDeAsignacion =
                String(puestoOriginal) !== String(puestoNuevo) ||
                String(enteOriginal) !== String(enteNuevo);


            // =================================================
            // ACTUALIZACIÓN NORMAL
            // =================================================

            if (!cambioDeAsignacion) {

                document
                    .getElementById('insp_tipo_actualizacion')
                    .value = '';

                form.submit();

                return;
            }


            // =================================================
            // CAMBIO DE ASIGNACIÓN
            // =================================================

            Swal.fire({

                title: 'Cambio de asignación',

                text:
                    'Detectamos un cambio en la adscripción. ¿Cómo deseas registrarlo?',

                icon: 'question',

                showDenyButton: true,
                showCancelButton: true,

                confirmButtonText: 'Cambio de asignación',
                denyButtonText: 'Corrección',
                cancelButtonText: 'Cancelar',

                reverseButtons: true,

                customClass: {

                    confirmButton:
                        'btn btn-primary px-3 font-weight-bold ml-2',

                    denyButton:
                        'btn btn-outline-primary px-3 font-weight-bold ml-2',

                    cancelButton:
                        'btn btn-secondary px-3'

                },

                buttonsStyling: false

            }).then((result) => {

                if (result.isConfirmed) {

                    document
                        .getElementById('insp_tipo_actualizacion')
                        .value = 'cambio';

                    form.submit();

                }

                else if (result.isDenied) {

                    document
                        .getElementById('insp_tipo_actualizacion')
                        .value = 'correccion';

                    form.submit();
                }

            });

        });


    // =========================================================
    // DEBOUNCE
    // =========================================================

    function debounce(func, wait) {

        let timeout;

        return function(...args) {

            clearTimeout(timeout);

            timeout = setTimeout(
                () => func.apply(this, args),
                wait
            );
        };
    }


    // =========================================================
    // FILTROS
    // =========================================================

    function registroCumpleFiltros(elemento) {

        const nivelFiltro =
            $('#filtroNivelGobierno').val();

        const enteFiltro =
            $('#filtroEnte').val();

        const puestoFiltro =
            $('#filtroPuesto').val();

        const revisionFiltro =
            $('#filtroRevision').val();


        const nivelId =
            String(elemento.dataset.nivelId || '');

        const enteId =
            String(elemento.dataset.enteId || '');

        const puestoId =
            String(elemento.dataset.puestoId || '');

        const ultimaActualizacion =
            elemento.dataset.ultimaActualizacion || '';


        const coincideNivel =
            !nivelFiltro ||
            nivelId === String(nivelFiltro);

        const coincideEnte =
            !enteFiltro ||
            enteId === String(enteFiltro);

        const coincidePuesto =
            !puestoFiltro ||
            puestoId === String(puestoFiltro);
        
        let coincideRevision = true;

        if (revisionFiltro === 'requiere_revision') {

            if (!ultimaActualizacion) {

                coincideRevision = false;

            } else {

                const fechaActualizacion =
                    new Date(ultimaActualizacion);

                const fechaLimite =
                    new Date();

                fechaLimite.setMonth(
                    fechaLimite.getMonth() - 3
                );

                coincideRevision =
                    fechaActualizacion <= fechaLimite;
            }
        }


        return (
            coincideNivel &&
            coincideEnte &&
            coincidePuesto &&
            coincideRevision
        );;
    }


    function obtenerCardsFiltradas() {

        const textoBusqueda =
            $('#inputBuscadorGlobal')
                .val()
                .toLowerCase()
                .trim();

        const cards =
            document.querySelectorAll(
                '#gridCards .contacto-card-item'
            );


        return Array.from(cards).filter(card => {

            const coincideFiltros =
                registroCumpleFiltros(card);

            const texto =
                (card.dataset.busqueda || '')
                    .toLowerCase();

            const coincideBusqueda =
                !textoBusqueda ||
                texto.includes(textoBusqueda);


            return (
                coincideFiltros &&
                coincideBusqueda
            );
        });
    }


    // =========================================================
    // CARDS
    // =========================================================

    function renderizarCards() {

        const todasLasCards =
            document.querySelectorAll(
                '#gridCards .contacto-card-item'
            );

        const cardsFiltradas =
            obtenerCardsFiltradas();

        const total =
            cardsFiltradas.length;

        const totalPaginas =
            Math.max(
                1,
                Math.ceil(total / CARDS_POR_PAGINA)
            );


        if (paginaCardsActual > totalPaginas) {
            paginaCardsActual = totalPaginas;
        }


        const inicio =
            (paginaCardsActual - 1) *
            CARDS_POR_PAGINA;

        const fin =
            inicio + CARDS_POR_PAGINA;

        const cardsVisibles =
            cardsFiltradas.slice(
                inicio,
                fin
            );


        todasLasCards.forEach(card => {
            card.style.display = 'none';
        });


        cardsVisibles.forEach(card => {
            card.style.display = '';
        });


        const info =
            document.getElementById('cardsInfo');


        if (info) {

            if (total === 0) {

                info.textContent =
                    'No se encontraron resultados';

            } else {

                const desde =
                    inicio + 1;

                const hasta =
                    Math.min(fin, total);

                info.textContent =
                    `Mostrando ${desde}-${hasta} de ${total}`;
            }
        }


        renderizarPaginacionCards(
            totalPaginas
        );
    }


    function renderizarPaginacionCards(totalPaginas) {

        const contenedor =
            document.getElementById(
                'cardsPagination'
            );

        if (!contenedor) {
            return;
        }


        contenedor.innerHTML = '';


        if (totalPaginas <= 1) {
            return;
        }


        const nav =
            document.createElement('nav');

        const ul =
            document.createElement('ul');

        ul.className =
            'pagination pagination-sm mb-0';


        // =====================================================
        // ANTERIOR
        // =====================================================

        const liAnterior =
            document.createElement('li');

        liAnterior.className =
            `page-item ${
                paginaCardsActual === 1
                    ? 'disabled'
                    : ''
            }`;


        const btnAnterior =
            document.createElement('button');

        btnAnterior.className =
            'page-link';

        btnAnterior.type =
            'button';

        btnAnterior.innerHTML =
            '&laquo;';


        btnAnterior.onclick =
            function() {

                if (paginaCardsActual > 1) {

                    paginaCardsActual--;

                    renderizarCards();

                    document
                        .getElementById('contenedorCards')
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                }
            };


        liAnterior.appendChild(
            btnAnterior
        );

        ul.appendChild(
            liAnterior
        );


        // =====================================================
        // PÁGINAS
        // =====================================================

        for (
            let pagina = 1;
            pagina <= totalPaginas;
            pagina++
        ) {

            const li =
                document.createElement('li');

            li.className =
                `page-item ${
                    pagina === paginaCardsActual
                        ? 'active'
                        : ''
                }`;


            const button =
                document.createElement('button');

            button.className =
                'page-link';

            button.type =
                'button';

            button.textContent =
                pagina;


            button.onclick =
                function() {

                    paginaCardsActual =
                        pagina;

                    renderizarCards();

                    document
                        .getElementById('contenedorCards')
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                };


            li.appendChild(
                button
            );

            ul.appendChild(
                li
            );
        }


        // =====================================================
        // SIGUIENTE
        // =====================================================

        const liSiguiente =
            document.createElement('li');

        liSiguiente.className =
            `page-item ${
                paginaCardsActual === totalPaginas
                    ? 'disabled'
                    : ''
            }`;


        const btnSiguiente =
            document.createElement('button');

        btnSiguiente.className =
            'page-link';

        btnSiguiente.type =
            'button';

        btnSiguiente.innerHTML =
            '&raquo;';


        btnSiguiente.onclick =
            function() {

                if (
                    paginaCardsActual <
                    totalPaginas
                ) {

                    paginaCardsActual++;

                    renderizarCards();

                    document
                        .getElementById('contenedorCards')
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                }
            };


        liSiguiente.appendChild(
            btnSiguiente
        );

        ul.appendChild(
            liSiguiente
        );


        nav.appendChild(
            ul
        );

        contenedor.appendChild(
            nav
        );
    }


    // =========================================================
    // FILTROS GLOBALES
    // =========================================================

    function aplicarFiltrosGlobales() {

        const textoBusqueda =
            $('#inputBuscadorGlobal')
                .val()
                .toLowerCase()
                .trim();


        if (vistaActual === 'tabla') {

            if (window.tablaContactosDT) {

                window.tablaContactosDT
                    .search(textoBusqueda)
                    .draw();
            }

            return;
        }


        paginaCardsActual = 1;

        renderizarCards();
    }


    function limpiarFiltros() {

        $('#inputBuscadorGlobal').val('');


        $('.filter-trigger').each(function() {

            if (this.tomselect) {

                this.tomselect.clear();

            } else {

                $(this)
                    .val('')
                    .trigger('change');
            }

        });


        paginaCardsActual = 1;

        aplicarFiltrosGlobales();
    }


    // =========================================================
    // INICIALIZACIÓN
    // =========================================================

    $(document).ready(function() {


        // =====================================================
        // DATATABLES
        // =====================================================

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {

                if (
                    settings.nTable.id !==
                    'tablaContactos'
                ) {
                    return true;
                }


                const row =
                    settings
                        .aoData[dataIndex]
                        .nTr;


                return registroCumpleFiltros(
                    row
                );
            }
        );


        if (
            $.fn.DataTable &&
            !$.fn.DataTable.isDataTable(
                '#tablaContactos'
            )
        ) {

            window.tablaContactosDT =
                $('#tablaContactos').DataTable({

                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    },

                    dom: 'rtip',

                    pageLength: 10,

                    responsive: true,

                    columnDefs: [
                        {
                            orderable: false,
                            targets: [-1]
                        }
                    ]

                });
        }


        // =====================================================
        // FILTROS
        // =====================================================

        $(document).on(
            'change',
            '.filter-trigger',
            function() {
                aplicarFiltrosGlobales();
            }
        );


        $('#inputBuscadorGlobal').on(
            'keyup',
            debounce(
                function() {
                    aplicarFiltrosGlobales();
                },
                300
            )
        );


        renderizarCards();

    });


    // =========================================================
    // VALIDACIONES CREAR CONTACTO
    // =========================================================

    $(document).ready(function() {

        const form =
            $('#modalCrearContacto form');

        const telefono =
            $('input[name="telefono"]');

        const celular =
            $('input[name="celular"]');

        const extension =
            $('input[name="extension"]');

        const correo =
            $('input[name="correo"]');


        function validarTelefono(campo) {

            const valor =
                campo.val().trim();


            if (valor === '') {

                campo.removeClass(
                    'is-invalid'
                );

                return true;
            }


            const valido =
                /^[0-9\s\-()]+$/.test(valor);


            campo.toggleClass(
                'is-invalid',
                !valido
            );


            return valido;
        }


        function validarExtension(campo) {

            const valor =
                campo.val().trim();


            if (valor === '') {

                campo.removeClass(
                    'is-invalid'
                );

                return true;
            }


            const valido =
                /^[0-9]+$/.test(valor);


            campo.toggleClass(
                'is-invalid',
                !valido
            );


            return valido;
        }


        function validarCorreo(campo) {

            const valor =
                campo.val().trim();


            if (valor === '') {

                campo.removeClass(
                    'is-invalid'
                );

                return true;
            }


            const valido =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
                    valor
                );


            campo.toggleClass(
                'is-invalid',
                !valido
            );


            return valido;
        }


        telefono.on(
            'blur',
            () => validarTelefono(telefono)
        );

        celular.on(
            'blur',
            () => validarTelefono(celular)
        );

        extension.on(
            'blur',
            () => validarExtension(extension)
        );

        correo.on(
            'blur',
            () => validarCorreo(correo)
        );


        telefono.on(
            'input',
            () => {
                if (telefono.hasClass('is-invalid')) {
                    validarTelefono(telefono);
                }
            }
        );


        celular.on(
            'input',
            () => {
                if (celular.hasClass('is-invalid')) {
                    validarTelefono(celular);
                }
            }
        );


        extension.on(
            'input',
            () => {
                if (extension.hasClass('is-invalid')) {
                    validarExtension(extension);
                }
            }
        );


        correo.on(
            'input',
            () => {
                if (correo.hasClass('is-invalid')) {
                    validarCorreo(correo);
                }
            }
        );


        form.on(
            'submit',
            function(event) {

                const telefonoValido =
                    validarTelefono(telefono);

                const celularValido =
                    validarTelefono(celular);

                const extensionValida =
                    validarExtension(extension);

                const correoValido =
                    validarCorreo(correo);


                if (
                    !telefonoValido ||
                    !celularValido ||
                    !extensionValida ||
                    !correoValido
                ) {

                    event.preventDefault();
                }

            }
        );

    });


    // =========================================================
    // ABRIR MODAL SI HAY ERRORES DE VALIDACIÓN
    // =========================================================

    @if ($errors->any() || session('asignacion_existente'))

        $(document).ready(function() {

            $('#modalCrearContacto').modal('show');

        });

    @endif


    @if (session('asignacion_existente'))

        $(document).ready(function() {

            const asignacionExistente =
                @json(session('asignacion_existente'));

            const form =
                $('#modalCrearContacto form');

            if (!form.length) {
                return;
            }


            let contenidoMedio = '';

            if (
                asignacionExistente.tipo_medio &&
                asignacionExistente.medio
            ) {

                contenidoMedio = `
                    <div class="mt-3">

                        <div class="small text-muted mb-1">
                            ${asignacionExistente.tipo_medio}
                        </div>

                        <div class="font-weight-bold text-dark">
                            ${asignacionExistente.medio}
                        </div>

                    </div>
                `;
            }


            Swal.fire({

                title: 'La asignación ya está ocupada',

                html: `
                    <div class="text-left">

                        <p class="mb-3">
                            Ya existe un titular activo para esta asignación.
                        </p>

                        <div class="border rounded p-3 bg-light">

                            <div class="small text-muted mb-1">
                                Titular actual
                            </div>

                            <div class="font-weight-bold text-dark">
                                ${asignacionExistente.nombre}
                            </div>

                            ${contenidoMedio}

                        </div>

                        <p class="small text-muted mt-3 mb-0">
                            Puedes cancelar el registro o reemplazar
                            al titular actual.
                        </p>

                    </div>
                `,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Reemplazar titular',
                cancelButtonText: 'Cancelar',

                reverseButtons: true,

                customClass: {

                    confirmButton:
                        'btn btn-primary px-3 font-weight-bold ml-2',

                    cancelButton:
                        'btn btn-secondary px-3'

                },

                buttonsStyling: false

            }).then((result) => {

                if (result.isConfirmed) {

                    const url =
                        "{{ route('contactos.reemplazar', ':id') }}"
                            .replace(
                                ':id',
                                asignacionExistente.contacto_id
                            );

                    form.attr('action', url);
                    form.attr('method', 'POST');

                    /*
                    * El formulario ya contiene todos los datos
                    * gracias a old() después del redirect.
                    *
                    * Enviamos directamente el formulario.
                    */
                    form.off('submit');

                    HTMLFormElement.prototype.submit.call(
                        form[0]
                    );

                    return;
                }


                if (
                    result.dismiss ===
                    Swal.DismissReason.cancel
                ) {

                    $('#modalCrearContacto').modal('show');

                }

            });

        });

    @endif


    // =========================================================
    // ESCAPE — CERRAR INSPECTOR
    // =========================================================

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Escape'
            ) {

                const inspector =
                    document.getElementById(
                        'inspectorLateral'
                    );


                if (
                    inspector &&
                    inspector.style.right === '0px'
                ) {

                    cerrarInspector();
                }
            }

        }
    );

    // =========================================================
    // OBSERVACIONES — ABRIR MODAL
    // =========================================================

    function configurarBotonesObservacion() {

        const botones =
            document.querySelectorAll(
                '.btn-nota-contacto'
            );

        botones.forEach(function(boton) {

            // Evitar registrar el evento dos veces
            if (boton.dataset.observacionConfigurada === '1') {
                return;
            }

            boton.dataset.observacionConfigurada = '1';

            boton.addEventListener('click', function(event) {

                // Evitar que el click llegue a otros elementos
                event.stopPropagation();

                // =================================================
                // DATOS DEL CONTACTO
                // =================================================

                const contactoId =
                    boton.dataset.id;

                const nombre =
                    boton.dataset.nombre || 'Contacto';

                // =================================================
                // FORMULARIO
                // =================================================

                const form =
                    document.getElementById(
                        'formAgregarObservacion'
                    );

                if (!form) {

                    console.error(
                        'No existe #formAgregarObservacion'
                    );

                    return;
                }

                // =================================================
                // CONFIGURAR ACTION
                // =================================================

                const action =
                    "{{ route('contactos.nota', ':id') }}"
                        .replace(
                            ':id',
                            contactoId
                        );

                form.setAttribute(
                    'action',
                    action
                );

                // =================================================
                // MOSTRAR NOMBRE
                // =================================================

                const nombreElemento =
                    document.getElementById(
                        'nombreContactoObservacion'
                    );

                if (nombreElemento) {

                    nombreElemento.textContent =
                        nombre;
                }

                // =================================================
                // LIMPIAR CAMPO
                // =================================================

                const input =
                    document.getElementById(
                        'observacionInput'
                    );

                if (input) {
                    input.value = '';
                }

                // =================================================
                // ABRIR MODAL
                // =================================================

                const modal =
                    $('#modalAgregarObservacion');

                if (!modal.length) {

                    console.error(
                        'No existe #modalAgregarObservacion'
                    );

                    return;
                }

                modal.modal('show');

            });

        });

    }


    // =========================================================
    // INICIALIZAR BOTONES DE OBSERVACIONES
    // =========================================================

    $(document).ready(function() {

        configurarBotonesObservacion();

    });
</script>
@endpush