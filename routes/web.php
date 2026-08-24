<?php

use App\Http\Controllers\Auth\AprobacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\EnteController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Redirección inicial
Route::get('/', function () {
    return Auth::check() ? redirect()->route('contactos.index') : redirect()->route('login');
});

// Logout Manual y Seguro
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// Autorizar solicitud de acceso
Route::get('/admin/autorizar-acceso/{user}/{role}', [AprobacionController::class, 'procesarAprobacion'])
    ->name('admin.aprobar.solicitud')
    ->middleware('signed');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Cargar directamente el directorio de contactos cuando entren a /dashboard
    Route::get('/dashboard', [ContactoController::class, 'index'])->name('dashboard');
    
    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Módulo: Contactos
    Route::get('contactos/verificar-asignacion', [ContactoController::class, 'verificarAsignacion'])->name('contactos.verificar-asignacion');
    Route::get('contactos/exportar/excel', [ContactoController::class, 'exportarExcel'])->name('contactos.exportar.excel'); // Exportar excel de contactos
    Route::get('contactos/exportar/pdf', [ContactoController::class, 'exportarPdf'])->name('contactos.exportar.pdf');
    Route::post('contactos/{id}/reemplazar', [ContactoController::class, 'reemplazar'])->name('contactos.reemplazar');
    Route::resource('contactos', ContactoController::class);
    Route::patch('contactos/{id}/nota', [ContactoController::class, 'updateNota'])->name('contactos.nota');
    Route::post('/contactos/enviar-informacion', [ContactoController::class, 'enviarInformacion'])->name('contactos.enviar-informacion'); // Compartir info contactos entre áreas


    // Módulos restringidos a Administradores y Coordinadores
    Route::middleware(['catalogos'])->group(function () {

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
        

        // Módulo: Sedes
        Route::get('/sedes', [SedeController::class, 'index'])->name('sedes.index');
        Route::post('/sedes', [SedeController::class, 'store'])->name('sedes.store');
        Route::put('/sedes/{sede}', [SedeController::class, 'update'])->name('sedes.update');
        Route::patch('/sedes/{sede}/toggle', [SedeController::class, 'toggle'])->name('sedes.toggle');
        
    });
    
});

require __DIR__.'/auth.php';