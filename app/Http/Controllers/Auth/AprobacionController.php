<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AprobacionController extends Controller
{
    public function procesarAprobacion(Request $request, User $user, $role)
    {
        // 1. Autorizar usuario
        $user->update([
            'activo' => true,
            'role_id' => $role
        ]);

        // 2. Enviar correo al nuevo usuario avisándole que ya puede entrar
        Mail::raw("Tu cuenta en el Directorio SESEA ha sido autorizada. Ya puedes acceder con tu correo y contraseña.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Acceso Autorizado - Sistema SESEA');
        });

        // 3. Vista de confirmación para el Admin
        return view('admin.aprobacion-exitosa');
    }
}