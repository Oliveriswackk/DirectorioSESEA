<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Directorio SESEA') }}</title>

    <!-- FontAwesome y Fuentes SBAdmin2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- CSS SBAdmin2 Base -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- TomSelect CSS (reemplazo select2) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">

    <!-- DataTables CSS Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <style>

    /* == Configuración TomSelect == */
        .ts-control { border-radius: 0.35rem !important; }
        .swal2-popup { font-family: 'Nunito', sans-serif !important; }

        /* Permite que el modal no corte elementos flotantes */
        .modal-content, .modal-body {
            overflow: visible !important;
        }

        /* Eleva la lista desplegable sobre el modal */
        .ts-dropdown {
            z-index: 1060 !important;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-address-book"></i>
                </div>
                <div class="sidebar-brand-text mx-2">Directorio</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Búsqueda Principal / Inicio -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('contactos.index') }}">
                    <i class="fas fa-fw fa-search"></i>
                    <span>Buscar Contactos</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Módulos de Operación -->
            <div class="sidebar-heading">INSTITUCIONES</div>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('entes.index') ? route('entes.index') : '#' }}">
                    <i class="fas fa-fw fa-landmark"></i>
                    <span>Entes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('sedes.index') ? route('sedes.index') : '#' }}">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Sedes</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Cobertura Territorial  -->
            <div class="sidebar-heading">REGIONES</div>

            <li class="nav-item {{ request()->routeIs('estados.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('estados.index') }}">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Estados</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('municipios.index') ? route('municipios.index') : '#' }}">
                    <i class="fas fa-fw fa-map-marker-alt"></i>
                    <span>Municipios</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Saludo -->
                    <div class="d-none d-md-flex align-items-center">
                        <span class="h5 mb-0 font-weight-bold text-gray-800">
                            ¡Qué gusto verte,
                            <span class="text-primary">{{ Auth::user()->name ?? 'Usuario' }}</span>!
                        </span>
                    </div>

                    <!-- Usuario -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle d-flex align-items-center"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">

                                <div class="text-right mr-3">

                                    <div class="font-weight-bold text-gray-800">
                                        {{ Auth::user()->name ?? 'Usuario' }}
                                    </div>

                                    <div class="small text-gray-500">
                                        {{ Auth::user()->role->nombre ?? 'Administrador' }}
                                    </div>

                                </div>

                                <span class="img-profile rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold"
                                    style="width:42px;height:42px;">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item btn-logout" href="#">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>

                                <!-- Formulario oculto indispensable para enviar el POST de cierre de sesión -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>

                        </li>

                    </ul>

                </nav>

                <!-- Contenido dinámico -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white py-3">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto small text-muted">
                        <span>Directorio Institucional</span>
                        <span class="px-1 text-black-50">|</span>
                        <span>SESEA Chihuahua</span>
                        <span class="px-1 text-black-50">|</span>
                        <span>v2.0 &copy; {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   <!-- Scripts Esenciales Base -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>
        
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- TomSelect JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- Handlers Globales de UI -->
    <script>
        $(document).ready(function() {

            // 1. Manejo Automático de SweetAlert2 desde Flashes de Sesión
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Logrado!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#4e73df'
                });
            @endif


            // 2. Inicializador Global de TomSelect
            window.initSelects = function(scope = document) {
                $(scope)
                    .find('select.select-search')
                    .each(function() {

                        if (this.tomselect) {
                            return;
                        }

                        const defaultValue = $(this).val();

                        const ts = new TomSelect(this, {
                            create: false,
                            sortField: {
                                field: 'text',
                                order: 'asc'
                            }
                        });

                        if (defaultValue) {
                            ts.setValue(defaultValue, true);
                        }
                    });
            };

            try {
                initSelects();
            } catch (error) {
                console.error('Error inicializando TomSelect:', error);
            }

            $('.modal').on('shown.bs.modal', function() {
                try {
                    initSelects(this);
                } catch (error) {
                    console.error('Error inicializando TomSelect en modal:', error);
                }
            });

            
            // 3. Confirmación Global para Botones o Formularios de Eliminación / Toggle
            $(document).on('click', '.btn-confirm', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                let message = $(this).data('confirm-message') || '¿Estás seguro de realizar esta acción?';

                Swal.fire({
                    title: '¿Confirmar acción?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#e74a3b',
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });


            // 4. Confirmación de Cierre de Sesión con SweetAlert2
            $(document).on('click', '.btn-logout', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Cerrar sesión?',
                    text: '¿Estás seguro de que deseas salir del sistema?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#e74a3b',
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#logout-form').submit();
                    }
                });
            });

        });
    </script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    @stack('scripts')
</body>
</html>