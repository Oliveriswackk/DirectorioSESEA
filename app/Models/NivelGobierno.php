<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelGobierno extends Model
{
    use HasFactory;

    protected $table = 'niveles_gobierno';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function entes(): HasMany
    {
        return $this->hasMany(Ente::class);
    }
}