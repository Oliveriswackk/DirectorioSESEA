@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            <!-- Icono llamativo pero sobrio -->
            <div class="mb-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
            </div>

            <!-- Mensaje para el usuario -->
            <h1 class="h3 font-weight-bold text-gray-800">¡Vaya! Ocurrió un imprevisto</h1>
            <p class="text-muted mb-4">
                {{ $exception->getMessage() ?: 'La acción que intentaste realizar no pudo completarse o la página no está disponible.' }}
            </p>

            <!-- Acciones de rescate -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm px-4 mr-2">
                    <i class="fas fa-arrow-left fa-xs mr-1"></i> Regresar a la pantalla anterior
                </a>
                <a href="{{ route('entes.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                    <i class="fas fa-home fa-xs mr-1"></i> Ir al Inicio
                </a>
            </div>

            <!-- Chivato técnico para ti (Sistemas) -->
            @if(config('app.debug'))
                <div class="card border-left-danger shadow-sm text-left mt-5 bg-light">
                    <div class="card-body small">
                        <span class="font-weight-bold text-danger"><i class="fas fa-bug mr-1"></i> Pista para Sistemas:</span>
                        <ul class="mb-0 mt-2 text-muted">
                            <li><strong>Ruta:</strong> {{ request()->fullUrl() }}</li>
                            <li><strong>Método:</strong> {{ request()->method() }}</li>
                            <li><strong>Excepción:</strong> {{ get_class($exception) }}</li>
                            <li><strong>Línea / Archivo:</strong> {{ $exception->getFile() }} (Línea {{ $exception->getLine() }})</li>
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection