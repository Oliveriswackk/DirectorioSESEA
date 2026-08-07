<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', config('app.name', 'Directorio SESEA'))</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,400i,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
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
                <a class="nav-link" href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}">
                    <i class="fas fa-fw fa-search"></i>
                    <span>Buscar Contactos</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Módulos de Operación -->
            <div class="sidebar-heading">INSTITUCIONES</div>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('entes.index') ? route('entes.index') : '#' }}">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Entes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('sedes.index') ? route('sedes.index') : '#' }}">
                    <i class="fas fa-fw fa-map-marker-alt"></i>
                    <span>Sedes</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Cobertura Territorial / Activos e Inactivos -->
            <div class="sidebar-heading">REGIONES</div>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('estados.index') ? route('estados.index') : '#' }}">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Estados</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ Route::has('municipios.index') ? route('municipios.index') : '#' }}">
                    <i class="fas fa-fw fa-city"></i>
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

                                <a class="dropdown-item"
                                href="#"
                                data-toggle="modal"
                                data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>

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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Cerrar sesión?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Cerrar sesión" si está listo para finalizar su sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')
</body>
</html>