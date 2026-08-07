<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'clave',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }
}