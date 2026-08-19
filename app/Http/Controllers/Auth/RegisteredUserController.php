<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\NuevaSolicitudAcceso;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Creamos el usuario inactivo y le asignamos su rol obligatorio por defecto
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 4,
            'activo' => 0,  // Bloqueado hasta autorización
        ]);

        //1.1 Registramos la acción en la bitácora
        app(\App\Services\BitacoraService::class)->registrar(
            'User',
            $user->id,
            'solicitud_acceso',
            'Solicitud de acceso al sistema.'
        );

        event(new Registered($user));

        // 2. ENVIAR CORREO LEIDO DEL .ENV
        $correoSistemas = env('ADMIN_EMAIL_NOTIFICATIONS'); 
        
        if ($correoSistemas) {
            Mail::to($correoSistemas)->send(new NuevaSolicitudAcceso($user));
        }

        // 3. Destruimos cualquier intento de sesión automática y mandamos al login con aviso
        auth()->logout();

        return redirect()->route('login')->with('status', '¡Solicitud enviada con éxito! Se ha notificado al área de sistemas para la autorización de tu cuenta.');
    }
}