<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado_id',
        'nombre',
        'clave',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    public function entes(): HasMany
    {
        return $this->hasMany(Ente::class);
    }
}