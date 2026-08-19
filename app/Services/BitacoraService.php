<?php

namespace App\Services;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraService
{
    /**
     * Registra una acción realizada dentro del sistema.
     */
    public function registrar(
        string $modelo,
        int $modeloId,
        string $accion,
        ?string $descripcion = null
    ): Bitacora {
        return Bitacora::create([
            'user_id' => Auth::id(),
            'modelo' => $modelo,
            'modelo_id' => $modeloId,
            'accion' => $accion,
            'descripcion' => $descripcion,
        ]);
    }
}