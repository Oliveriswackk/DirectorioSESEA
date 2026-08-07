<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contacto_id')
                ->nullable()
                ->constrained('contactos')
                ->nullOnDelete();

            $table->foreignId('ente_id')
                ->constrained('entes')
                ->cascadeOnDelete();

            $table->foreignId('sede_id')
                ->nullable()
                ->constrained('sedes')
                ->nullOnDelete();

            $table->foreignId('puesto_id')
                ->constrained('puestos');

            $table->string('correo', 255)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('extension', 20)->nullable();
            $table->string('celular', 50)->nullable();

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->text('observaciones')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};
