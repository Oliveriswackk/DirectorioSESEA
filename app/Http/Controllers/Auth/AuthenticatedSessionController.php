<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BitacoraService;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(
        LoginRequest $request,
        BitacoraService $bitacora
    ): RedirectResponse {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
                        ]);
        }

        // Verificar si el usuario está activo
        if (! Auth::user()->activo) {
            Auth::logout();

            return back()->withInput($request->only('email'))
                        ->withErrors([
                            'email' => 'Tu cuenta se encuentra pendiente de autorización por el área de sistemas.',
                        ]);
        }

        $request->session()->regenerate();

        $bitacora->registrar(
            'User',
            Auth::id(),
            'login',
            'Inicio de sesión en el sistema.'
        );

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(
        Request $request,
        BitacoraService $bitacora
    ): RedirectResponse {
        $userId = Auth::id();

        $bitacora->registrar(
            'User',
            $userId,
            'logout',
            'Cierre de sesión en el sistema.'
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
