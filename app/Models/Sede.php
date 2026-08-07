<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
        'ente_id',
        'nombre',
        'direccion_texto',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function ente(): BelongsTo
    {
        return $this->belongsTo(Ente::class);
    }
}