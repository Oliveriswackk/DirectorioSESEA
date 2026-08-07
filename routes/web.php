<?php

use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ProfileController;
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

});

require __DIR__.'/auth.php';