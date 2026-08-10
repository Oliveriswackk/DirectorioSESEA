<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
        * Municipio asociado al ente.
        * No implica pertenencia administrativa; puede representar cobertura,
        * ubicación o relación territorial.
        */
        
        Schema::create('entes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nivel_gobierno_id')->constrained('niveles_gobierno');
            
            $table->foreignId('municipio_id')->nullable() 
                ->constrained('municipios')->nullOnDelete();

            $table->string('nombre');
            $table->string('siglas')->nullable();
            $table->string('conmutador', 50)->nullable();
            $table->string('sitio_web')->nullable();

            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entes');
    }
};