    <!-- ================================================================= -->
    <!-- 1. MODAL: CREAR NUEVA ASIGNACIÓN / CONTACTO    -->
    <!-- ================================================================= -->
    <div class="modal fade" id="modalCrearContacto" tabindex="-1" role="dialog" aria-labelledby="modalCrearContactoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem; overflow: hidden;">
                
                <!-- Header Institucional -->
                <div class="modal-header bg-light border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title font-weight-bold text-gray-900" id="modalCrearContactoLabel">
                        <i class="fas fa-user-plus text-primary mr-2"></i> Registrar Nuevo Contacto
                    </h5>
                    <button type="button" class="close text-gray-500" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('contactos.store') }}" method="POST" class="user">
                    @csrf
                    
                    <div class="modal-body px-4 py-4 bg-white">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger border-left-danger shadow-sm mb-4">
                                <strong>No se pudo registrar el contacto.</strong>
                                <ul class="mb-0 mt-2 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Bloque 1: Datos Personales -->
                        <div class="mb-4">
                            <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">
                                1. Información Personal
                            </h6>
                            <div class="row">
                                <div class="col-md-4 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" class="form-control" required placeholder="Ej. María José"autofocus>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" class="form-control">
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Bloque 2: Ubicación Institucional -->
                        <div class="mb-4">
                            <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">
                                2. Ubicación Institucional
                            </h6>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">
                                        Ente <span class="text-danger">*</span>
                                    </label>
                                    <select name="ente_id" class="form-control select-search" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($entes ?? [] as $ente)
                                            <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">
                                        Puesto <span class="text-danger">*</span>
                                    </label>
                                    <select name="puesto_id" class="form-control select-search" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($puestos ?? [] as $puesto)
                                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group mb-0">
                                    <label class="font-weight-bold text-gray-700 small">Sede <span class="text-muted font-weight-normal">(Opcional)</span></label>
                                    <select name="sede_id" class="form-control select-search">
                                        <option value="">Seleccione...</option>
                                        @foreach($sedes ?? [] as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bloque 3: Medios de Contacto -->
                        <div class="mb-4">
                            <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">
                                3. Medios de Comunicación
                            </h6>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Correo Institucional</label>
                                    <input type="email" name="correo"     class="form-control @error('correo') is-invalid @enderror" maxlength="255" placeholder="ejemplo@correo.gob.mx" value="{{ old('correo') }}">
                                    @error('correo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Teléfono / Oficina</label>
                                    <input type="text" name="telefono" class="form-control" inputmode="tel" pattern="[0-9\s\-\(\)]+" inputmode="tel" maxlength="20" placeholder="Ej. 614 123 4567" value="{{ old('telefono') }}">
                                    @error('telefono')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 form-group mb-3">
                                    <label class="font-weight-bold text-gray-700 small">Extensión</label>
                                    <input type="text" name="extension" class="form-control" inputmode="tel" maxlength="10" placeholder="Ej. 1234" value="{{ old('extension') }}">
                                    @error('extension')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-0">
                                    <label class="font-weight-bold text-gray-700 small">Celular</label>
                                    <input type="text" name="celular" class="form-control" inputmode="tel" maxlength="20" placeholder="Ej. 614 123 4567" value="{{ old('celular') }}">
                                    @error('celular')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bloque 4: Observaciones -->
                        <div>
                            <h6 class="text-xs font-weight-bold text-uppercase text-muted mb-3 border-bottom pb-1">
                                4. Observaciones Iniciales
                            </h6>
                            <div class="form-group mb-0">
                                <textarea name="observaciones" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-light border-top px-4 py-3">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Guardar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ================================================================= -->
    <!-- 2. CAJÓN LATERAL — INSPECTOR DE CONTACTO / VINCULACIÓN            -->
    <!-- ================================================================= -->

    <div
        id="inspectorLateral"
        class="inspector-lateral"
        style="
            position: fixed;
            top: 0;
            right: -480px;
            width: 480px;
            height: 100vh;
            background: #fff;
            z-index: 1050;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: -4px 0 20px rgba(0,0,0,.12);
        "
    >

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <header class="bg-white border-bottom flex-shrink-0" style="z-index: 2;">

            <div class="px-4 pt-3 pb-2">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="pr-3">

                        <div class="d-flex align-items-center mb-1">

                            <span
                                id="insp_estado_badge"
                                class="badge badge-success mr-2"
                                style="font-size: .6rem; letter-spacing: .04rem; font-weight: 700;"
                            >
                                ACTIVO
                            </span>

                            <span
                                class="text-muted text-uppercase font-weight-bold"
                                style="font-size: .6rem; letter-spacing: .06rem;"
                            >
                                Inspector institucional
                            </span>

                        </div>

                        <h5
                            id="insp_nombre_display"
                            class="mb-0 font-weight-bold text-gray-900"
                            style="font-size: 1rem;"
                        >
                            Detalles del contacto
                        </h5>

                    </div>

                    <button
                        type="button"
                        class="btn btn-link text-muted p-0 shadow-none"
                        onclick="cerrarInspector()"
                        title="Cerrar inspector"
                        style="font-size: 1.15rem; outline: none;"
                    >
                        <i class="fas fa-times"></i>
                    </button>

                </div>

            </div>


            {{-- =================================================
                NAVEGACIÓN INTERNA
            ================================================== --}}
            <nav class="px-4">

                <div class="d-flex" style="gap: 1.5rem;">

                    <button
                        type="button"
                        id="tabInspectorActual"
                        class="inspector-tab active"
                        onclick="switchTabInspector('actual')"
                    >
                        Información actual
                    </button>

                    <button
                        type="button"
                        id="tabInspectorHistorial"
                        class="inspector-tab"
                        onclick="switchTabInspector('historial')"
                    >
                        Historial
                    </button>

                </div>

            </nav>

        </header>


        {{-- =====================================================
            CONTENIDO DEL INSPECTOR
        ====================================================== --}}
        <div class="px-4 py-4 flex-grow-1" style="overflow-y: auto; min-height: 0;">


            {{-- =================================================
                TAB: INFORMACIÓN ACTUAL
            ================================================== --}}
            <div id="tabInspectorActualContenido">

                <form
                    id="formEditarInspector"
                    method="POST"
                >

                    @csrf
                    @method('PUT')

                    <input
                        type="hidden"
                        name="tipo_actualizacion"
                        id="insp_tipo_actualizacion"
                        value=""
                    >


                    {{-- =================================================
                        IDENTIDAD
                    ================================================== --}}
                    <section class="mb-4">

                        <div class="d-flex align-items-center mb-3">

                            <i class="fas fa-id-card text-primary mr-2"></i>

                            <h6
                                class="mb-0 text-uppercase font-weight-bold text-gray-800"
                                style="font-size: .75rem; letter-spacing: .05rem;"
                            >
                                Identidad
                            </h6>

                        </div>


                        {{-- Nombre --}}
                        <div class="form-group mb-3">

                            <label
                                for="insp_nombre"
                                class="small font-weight-bold text-gray-700"
                            >
                                Nombre(s)
                            </label>

                            <input
                                type="text"
                                class="form-control form-control-sm"
                                name="nombre"
                                id="insp_nombre"
                                required
                            >

                        </div>


                        {{-- Apellidos --}}
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label
                                        for="insp_apellido_paterno"
                                        class="small font-weight-bold text-gray-700"
                                    >
                                        Apellido paterno
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="apellido_paterno"
                                        id="insp_apellido_paterno"
                                    >

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group mb-0">

                                    <label
                                        for="insp_apellido_materno_input"
                                        class="small font-weight-bold text-gray-700"
                                    >
                                        Apellido materno
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="apellido_materno"
                                        id="insp_apellido_materno_input"
                                    >

                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        ADSCRIPCIÓN
                    ================================================== --}}
                    <section class="mb-4">

                        <div class="d-flex align-items-center mb-3">

                            <i class="fas fa-sitemap text-primary mr-2"></i>

                            <h6
                                class="mb-0 text-uppercase font-weight-bold text-gray-800"
                                style="font-size: .75rem; letter-spacing: .05rem;"
                            >
                                Adscripción actual
                            </h6>

                        </div>


                        {{-- Ente --}}
                        <div class="form-group mb-3">

                            <label
                                for="insp_ente_id"
                                class="small font-weight-bold text-gray-700"
                            >
                                Ente público
                            </label>

                            <select
                                name="ente_id"
                                id="insp_ente_id"
                                class="select-search form-control form-control-sm"
                            >

                                <option value="">
                                    Seleccione un ente...
                                </option>

                                @foreach($entes as $ente)

                                    <option value="{{ $ente->id }}">
                                        {{ $ente->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Sede --}}
                        <div class="form-group mb-3">

                            <label
                                for="insp_sede_id"
                                class="small font-weight-bold text-gray-700"
                            >
                                Sede
                            </label>

                            <select
                                name="sede_id"
                                id="insp_sede_id"
                                class="select-search form-control form-control-sm"
                            >

                                <option value="">
                                    Seleccione una sede...
                                </option>

                                @foreach($sedes as $sede)

                                    <option value="{{ $sede->id }}">
                                        {{ $sede->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Puesto --}}
                        <div class="form-group mb-0">

                            <label
                                for="insp_puesto_id"
                                class="small font-weight-bold text-gray-700"
                            >
                                Puesto
                            </label>

                            <select
                                name="puesto_id"
                                id="insp_puesto_id"
                                class="select-search form-control form-control-sm"
                            >

                                <option value="">
                                    Seleccione un puesto...
                                </option>

                                @foreach($puestos as $puesto)

                                    <option value="{{ $puesto->id }}">
                                        {{ $puesto->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </section>


                    {{-- =================================================
                        CONTEXTO TERRITORIAL
                    ================================================== --}}
                    <section class="mb-4 px-3 py-3 border rounded bg-light">

                        <div class="mb-3">

                            <div
                                class="text-muted font-weight-bold mb-1"
                                style="font-size: .65rem;"
                            >
                                DIRECCIÓN
                            </div>

                            <div
                                id="insp_direccion"
                                class="small text-gray-800"
                            >
                                Sin dirección registrada
                            </div>

                        </div>


                        <div class="row no-gutters">

                            <div class="col-4 pr-2">

                                <div
                                    class="text-muted font-weight-bold mb-1"
                                    style="font-size: .65rem;"
                                >
                                    MUNICIPIO
                                </div>

                                <div
                                    id="insp_municipio"
                                    class="small text-gray-800 text-truncate"
                                >
                                    No disponible
                                </div>

                            </div>


                            <div class="col-4 px-2 border-left">

                                <div
                                    class="text-muted font-weight-bold mb-1"
                                    style="font-size: .65rem;"
                                >
                                    ESTADO
                                </div>

                                <div
                                    id="insp_estado"
                                    class="small text-gray-800 text-truncate"
                                >
                                    No disponible
                                </div>

                            </div>


                            <div class="col-4 pl-2 border-left">

                                <div
                                    class="text-muted font-weight-bold mb-1"
                                    style="font-size: .65rem;"
                                >
                                    NIVEL
                                </div>

                                <div
                                    id="insp_nivel"
                                    class="small text-gray-800 text-truncate"
                                >
                                    No disponible
                                </div>

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        CONTACTO
                    ================================================== --}}
                    <section class="mb-4">

                        <div class="d-flex align-items-center mb-3">

                            <i class="fas fa-address-book text-primary mr-2"></i>

                            <h6
                                class="mb-0 text-uppercase font-weight-bold text-gray-800"
                                style="font-size: .75rem; letter-spacing: .05rem;"
                            >
                                Contacto
                            </h6>

                        </div>


                        {{-- Correo --}}
                        <div class="form-group mb-3">

                            <label
                                for="insp_correo"
                                class="small font-weight-bold text-gray-700"
                            >
                                Correo institucional
                            </label>

                            <div class="input-group input-group-sm">

                                <div class="input-group-prepend">

                                    <span class="input-group-text bg-light">

                                        <i class="fas fa-envelope text-muted"></i>

                                    </span>

                                </div>

                                <input
                                    type="email"
                                    class="form-control"
                                    name="correo"
                                    id="insp_correo"
                                    placeholder="correo@ejemplo.com"
                                >

                            </div>

                        </div>


                        {{-- Teléfono + extensión --}}
                        <div class="row">

                            <div class="col-md-8">

                                <div class="form-group mb-3">

                                    <label
                                        for="insp_telefono"
                                        class="small font-weight-bold text-gray-700"
                                    >
                                        Teléfono directo
                                    </label>

                                    <div class="input-group input-group-sm">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text bg-light">

                                                <i class="fas fa-phone text-muted"></i>

                                            </span>

                                        </div>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="telefono"
                                            id="insp_telefono"
                                        >

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="form-group mb-3">

                                    <label
                                        for="insp_extension"
                                        class="small font-weight-bold text-gray-700"
                                    >
                                        Extensión
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="extension"
                                        id="insp_extension"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- Celular --}}
                        <div class="form-group mb-0">

                            <label
                                for="insp_celular"
                                class="small font-weight-bold text-gray-700"
                            >
                                Celular institucional
                            </label>

                            <div class="input-group input-group-sm">

                                <div class="input-group-prepend">

                                    <span class="input-group-text bg-light">

                                        <i class="fas fa-mobile-alt text-muted"></i>

                                    </span>

                                </div>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="celular"
                                    id="insp_celular"
                                >

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        OBSERVACIONES
                    ================================================== --}}
                    <section class="mb-0">

                        <div class="d-flex align-items-center mb-3">

                            <i class="fas fa-sticky-note text-primary mr-2"></i>

                            <h6
                                class="mb-0 text-uppercase font-weight-bold text-gray-800"
                                style="font-size: .75rem; letter-spacing: .05rem;"
                            >
                                Observaciones
                            </h6>

                        </div>

                        <textarea
                            class="form-control form-control-sm"
                            name="observaciones"
                            id="insp_observaciones"
                            rows="3"
                            placeholder="Notas sobre el contacto..."
                        ></textarea>

                    </section>

                </form>

            </div>


            {{-- =================================================
                TAB: HISTORIAL
            ================================================== --}}
            <div
                id="tabInspectorHistorialContenido"
                style="display: none;"
            >

                <section class="mb-0">

                    <div class="d-flex align-items-center mb-3">

                        <i class="fas fa-history text-primary mr-2"></i>

                        <h6
                            class="mb-0 text-uppercase font-weight-bold text-gray-800"
                            style="font-size: .75rem; letter-spacing: .05rem;"
                        >
                            Historial de cambios
                        </h6>

                    </div>


                    <div
                        class="border rounded bg-light p-4 text-center"
                    >

                        <i class="fas fa-clock text-muted mb-2"></i>

                        <div class="small font-weight-bold text-gray-700">
                            Historial disponible próximamente
                        </div>

                        <div class="small text-muted mt-1">
                            Aquí se mostrarán los cambios realizados sobre este contacto.
                        </div>

                    </div>

                </section>

            </div>

        </div>


        {{-- =====================================================
            FOOTER DE ACCIONES
        ====================================================== --}}
        <div class="bg-white border-top px-4 py-3 flex-shrink-0 d-flex justify-content-between align-items-center" style="z-index: 2;">

            <button
                type="button"
                class="btn btn-secondary btn-sm"
                onclick="cerrarInspector()"
            >
                Cancelar
            </button>

            <button
                type="submit"
                form="formEditarInspector"
                class="btn btn-primary btn-sm px-3"
            >
                <i class="fas fa-save mr-1"></i>
                Guardar cambios
            </button>

        </div>

    </div>


    {{-- =====================================================
        ESTILOS DEL INSPECTOR
    ====================================================== --}}
    <style>
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
    </style>