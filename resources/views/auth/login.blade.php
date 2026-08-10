<x-guest-layout>

<!-- CSS personalizado -->
<style>
    .transition-link:hover {
        color: #5e18b6 !important;
        text-decoration: none;
    }
</style>

    <!-- Fondo claro refinado con sutil malla geométrica institucional -->
    <div class="position-relative vh-100 d-flex align-items-center justify-content-center overflow-hidden" style="background-color: #f4f6f9; background-image: radial-gradient(#d1d8e0 1px, transparent 1px); background-size: 24px 24px;">
        
        <!-- Destellos lumínicos difuminados en segundo plano para dar volumen y calidez -->
        <div class="position-absolute rounded-circle" style="width: 500px; height: 500px; background: rgba(78, 115, 223, 0.07); top: -100px; left: -100px; filter: blur(70px); pointer-events: none;"></div>
        <div class="position-absolute rounded-circle" style="width: 450px; height: 450px; background: rgba(94, 24, 182, 0.04); bottom: -120px; right: -120px; filter: blur(80px); pointer-events: none;"></div>

        <!-- Tarjeta de Acceso Principal (Con relieve de alta gama) -->
        <div class="container" style="max-width: 440px; z-index: 10;">
            <div class="card border-0 shadow-lg" style="border-radius: 1rem; background: #ffffff; border-top: 4px solid #4e73df !important;">
                
                <div class="card-body p-4 p-sm-5">
                    
                    <!-- Logotipo y Encabezado Institucional con Presencia -->
                    <div class="text-center mb-4 pb-2 border-bottom">
                        <!-- Aquí incluyes tu imagen de logo. Reemplaza la ruta si es necesario (ej: asset('img/logo-sesea.png')) -->
                        <div class="mb-3 d-inline-block">
                            <img src="{{ asset('img/logo.png') }}" alt="SESEA Logo" style="max-height: 52px; width: auto;" class="img-fluid">
                        </div>
                        <h5 class="font-weight-bold text-gray-900 mb-1" style="letter-spacing: -0.3px;">Directorio Institucional</h5>
                        <p class="text-muted small mb-0">Sistema de Consulta y Gestión</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- ALERTA DE ERRORES  -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small py-2 px-3 mb-3 shadow-sm text-center" style="border-radius: 0.5rem; background-color: #f8d7da; color: #721c24;">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="user">
                        @csrf

                        <!-- Correo Electrónico -->
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-gray-700 mb-1" for="email">Correo institucional</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted pl-3" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;"><i class="fas fa-envelope fa-sm text-gray-400"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control bg-light border-left-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                       placeholder="nombre@seseachihuahua.gob.mx" style="height: 46px; font-size: 0.925rem; border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small pl-1" />
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="small font-weight-bold text-gray-700 m-0" for="password">Contraseña</label>
                                @if (Route::has('password.request'))
                                    <a class="small text-primary font-weight-bold" href="{{ route('password.request') }}">¿Olvidaste tu clave?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted pl-3" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;"><i class="fas fa-lock fa-sm text-gray-400"></i></span>
                                </div>
                                
                                <input id="password" type="password" class="form-control bg-light border-left-0 border-right-0 @error('password') is-invalid @enderror @error('email') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password" 
                                    placeholder="••••••••••••" style="height: 46px; font-size: 0.925rem;">
                                    
                                <!-- Botón para ver/ocultar contraseña -->
                                <div class="input-group-append">
                                    <button class="input-group-text bg-light border-left-0 text-muted px-3" type="button" id="togglePassword" style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; cursor: pointer;">
                                        <i class="fas fa-eye fa-sm text-gray-400" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small pl-1" />
                        </div>

                        <!-- Recordar Sesión -->
                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                                <label class="custom-control-label text-muted" for="remember_me">Mantener sesión iniciada</label>
                            </div>
                        </div>

                        <!-- Botón de Ingreso con fuerza visual -->
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-3" style="border-radius: 0.5rem; font-size: 0.95rem; letter-spacing: 0.3px;">
                            Ingresar al Sistema <i class="fas fa-arrow-right ml-2 fa-xs"></i>
                        </button>

                        <!-- Enlace para solicitar acceso -->
                        <div class="text-center mt-3">
                            <span class="text-muted small">¿No tienes una cuenta?</span>
                            <a class="small font-weight-bold text-muted ml-1 transition-link" href="{{ route('register') }}" style="transition: color 0.2s ease;">
                                Solicitar Acceso
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Pie de página institucional sobrio -->
            <div class="text-center mt-4">
                <span class="text-muted font-weight-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SECRETARÍA EJECUTIVA DEL SISTEMA ESTATAL ANTICORRUPCIÓN</span>
            </div>
        </div>

    </div>

    <!-- Ver Contraseña -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</x-guest-layout>