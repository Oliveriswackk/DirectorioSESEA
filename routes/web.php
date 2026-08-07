<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\EnteController;
use App\Http\Controllers\SedeController;
use Illuminate\Support\Facades\Route;

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Módulo: Estados
    Route::prefix('estados')->name('estados.')->group(function () {
        Route::get('/', [EstadoController::class, 'index'])->name('index');
        Route::post('/', [EstadoController::class, 'store'])->name('store');
        Route::put('/{estado}', [EstadoController::class, 'update'])->name('update');
        Route::patch('/{estado}/toggle', [EstadoController::class, 'toggleActive'])->name('toggle');
    });


    // Módulo: Municipios
    Route::resource('municipios', MunicipioController::class)->except(['create', 'edit', 'show', 'destroy']);
    Route::patch('municipios/{municipio}/toggle', [MunicipioController::class, 'toggleActive'])->name('municipios.toggle');


    // Módulo: Entes
    Route::get('/entes', [EnteController::class, 'index'])->name('entes.index');
    Route::post('/entes', [EnteController::class, 'store'])->name('entes.store');
    Route::put('/entes/{ente}', [EnteController::class, 'update'])->name('entes.update');
    Route::patch('/entes/{ente}/toggle', [EnteController::class, 'toggle'])->name('entes.toggle');
    
});

require __DIR__.'/auth.php';