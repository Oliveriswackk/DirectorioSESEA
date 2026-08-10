<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'contacto_id',
        'ente_id',
        'sede_id',
        'puesto_id',
        'correo',
        'telefono',
        'extension',
        'celular',
        'fecha_inicio',
        'fecha_fin',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function contacto(): BelongsTo
    {
        return $this->belongsTo(Contacto::class);
    }

    public function ente(): BelongsTo
    {
        return $this->belongsTo(Ente::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }

    public function getConmutadorAttribute()
    {
        // Primero, intenta buscar el conmutador de la Sede (si existe y tiene valor)
        if ($this->sede && $this->sede->conmutador) {
            return $this->sede->conmutador;
        }
        
        // Si no, recurre al del Ente (a nivel institucional)
        if ($this->ente && $this->ente->conmutador) {
            return $this->ente->conmutador;
        }
        
        return 'N/A'; // O simplemente vacío
    }
}