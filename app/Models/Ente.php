<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(NivelGobierno::class);
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function sedes(): HasMany
    {
        return $this->hasMany(Sede::class);
    }
}