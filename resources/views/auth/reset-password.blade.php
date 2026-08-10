<x-guest-layout>
    <div class="position-relative vh-100 d-flex align-items-center justify-content-center overflow-hidden" style="background-color: #f4f6f9; background-image: radial-gradient(#d1d8e0 1px, transparent 1px); background-size: 24px 24px;">
        
        <!-- Efectos de luz difuminada de fondo -->
        <div class="position-absolute rounded-circle" style="width: 500px; height: 500px; background: rgba(78, 115, 223, 0.07); top: -100px; left: -100px; filter: blur(70px); pointer-events: none;"></div>
        <div class="position-absolute rounded-circle" style="width: 450px; height: 450px; background: rgba(94, 24, 182, 0.04); bottom: -120px; right: -120px; filter: blur(80px); pointer-events: none;"></div>

        <!-- Tarjeta de Restablecimiento -->
        <div class="container px-3" style="max-width: 480px; z-index: 10;">
            <div class="card border-0 shadow-lg" style="border-radius: 1rem; background: #ffffff; border-top: 4px solid #4e73df !important;">
                
                <div class="card-body p-4 p-sm-5">
                    
                    <!-- Encabezado Institucional -->
                    <div class="text-center mb-4 pb-2 border-bottom">
                        <div class="mb-3 d-inline-block">
                            <img src="{{ asset('img/logo.png') }}" alt="SESEA Logo" style="max-height: 48px; width: auto;" class="img-fluid">
                        </div>
                        <h5 class="font-weight-bold text-gray-900 mb-1" style="letter-spacing: -0.3px;">Nueva Contraseña</h5>
                        <p class="text-muted small mb-0 px-2">Ingresa tu correo y define tu nueva clave de acceso</p>
                    </div>

                    <!-- Errores de validación limpios -->
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small py-2 px-3 mb-3 shadow-sm text-center" style="border-radius: 0.5rem; background-color: #f8d7da; color: #721c24;">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" class="user">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Correo Electrónico -->
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-gray-700 mb-1" for="email">Correo institucional</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted pl-3" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;"><i class="fas fa-envelope fa-sm text-gray-400"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control bg-light border-left-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" 
                                       placeholder="nombre@seseachihuahua.gob.mx" style="height: 44px; font-size: 0.925rem;">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small pl-1" />
                        </div>

                        <!-- Nueva Contraseña -->
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-gray-700 mb-1" for="password">Nueva contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted pl-3" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;"><i class="fas fa-lock fa-sm text-gray-400"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control bg-light border-left-0 border-right-0 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password" 
                                       placeholder="••••••••••••" style="height: 44px; font-size: 0.925rem;">
                                
                                <!-- Botón para ver/ocultar contraseña -->
                                <div class="input-group-append">
                                    <button class="input-group-text bg-light border-left-0 text-muted px-3" type="button" id="togglePassword" style="border-top-right-radius: 0.5rem; border-bottom-right-radius: 0.5rem; cursor: pointer;">
                                        <i class="fas fa-eye fa-sm text-gray-400" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small pl-1" />
                        </div>

                        <!-- Confirmar Nueva Contraseña -->
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-gray-700 mb-1" for="password_confirmation">Confirmar contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0 text-muted pl-3" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;"><i class="fas fa-check-circle fa-sm text-gray-400"></i></span>
                                </div>
                                <input id="password_confirmation" type="password" class="form-control bg-light border-left-0 @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" required autocomplete="new-password" 
                                       placeholder="••••••••••••" style="height: 44px; font-size: 0.925rem;">
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small pl-1" />
                        </div>

                        <!-- Botón Restablecer -->
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-3 mb-3" style="border-radius: 0.5rem; font-size: 0.95rem;">
                            Restablecer Contraseña <i class="fas fa-key ml-2 fa-xs"></i>
                        </button>
                    </form>

                    <!-- Enlace para volver al Login -->
                    <div class="text-center pt-3 border-top">
                        <a class="small font-weight-bold text-primary" href="{{ route('login') }}">
                            ← Volver al inicio de sesión
                        </a>
                    </div>

                </div>
            </div>

            <!-- Pie de página institucional -->
            <div class="text-center mt-4">
                <span class="text-muted font-weight-bold" style="font-size: 0.7rem; letter-spacing: 1px;">SECRETARÍA EJECUTIVA DEL SISTEMA ESTATAL ANTICORRUPCIÓN</span>
            </div>
        </div>

    </div>

    <!-- Script Ver Contraseña -->
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