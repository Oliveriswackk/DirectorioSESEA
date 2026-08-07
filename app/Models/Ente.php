<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Ente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nivel_gobierno_id',
        'municipio_id',
        'nombre',
        'siglas',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function nivelGobierno(): BelongsTo
    {
        return $this->belongsTo(NivelGobierno::class, 'nivel_gobierno_id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function estado(): HasOneThrough
    {
        return $this->hasOneThrough(Estado::class, Municipio::class, 'id', 'id', 'municipio_id', 'estado_id');
    }

    public function sedes(): HasMany
    {
        return $this->hasMany(Sede::class);
    }
}