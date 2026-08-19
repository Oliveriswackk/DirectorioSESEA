<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacora';

    public const ACCION_LOGIN = 'iniciar_sesion';
    public const ACCION_LOGOUT = 'cerrar_sesion';

    public const ACCION_CREAR = 'crear';
    public const ACCION_MODIFICAR = 'modificar';
    public const ACCION_INACTIVAR = 'inactivar';

    public const ACCION_OBSERVACION = 'agregar_observacion';

    protected $fillable = [
        'user_id',
        'modelo',
        'modelo_id',
        'accion',
        'descripcion',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}