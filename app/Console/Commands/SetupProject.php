<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupProject extends Command
{
    protected $signature = 'app:setup';
    protected $description = 'Inicializador visual de entorno para el sistema de contactos';

    public function handle()
    {
        // Limpiar pantalla para dar efecto de aplicación de escritorio/CLI pro
        if (PHP_OS_FAMILY !== 'Windows') {
            system('clear');
        }

        // Arte ASCII minimalista estilo terminal de sistema crítico
        $this->line("\033[35m"); // Color distintivo tipo acento (#5E18B6 aprox o morado terminal)
        $this->line("   ___ ___  _  _ _____ ___  ___  ___  ___ ");
        $this->line("  / __/ _ \\| \\| |_   _| _ \\/ _ \\| _ \\/ __|");
        $this->line(" | (_| (_) | .` | | | |   / (_) |   / (__ ");
        $this->line("  \\___\\___/|_|\\_| |_| |_|_\\\\___/|_|_\\\\___|");
        $this->line("\033[0m");
        
        $this->info("   SISTEMA DE TRAZABILIDAD Y DIRECTORIO INSTITUCIONAL");
        $this->line("   <comment>Configurador Maestro v1.0.0</comment>\n");

        // 1. Verificación del entorno
        $this->output->title('Fase 1: Verificación de Entorno');
        if (!file_exists('.env')) {
            copy('.env.example', '.env');
            $this->components->info('Archivo .env generado a partir de la plantilla.');
        } else {
            $this->components->warn('El archivo .env ya existía; se omite la copia.');
        }
        $this->call('key:generate');

        // 2. Configuración de Base de Datos Interactiva con estilo de tabla
        $this->output->title('Fase 2: Conexión a Base de Datos');
        
        $dbName = $this->ask('Nombre de la base de datos', 'directorio_db');
        $dbUser = $this->ask('Usuario administrador de MySQL', 'root');
        $dbPass = $this->secret('Contraseña de acceso (se ocultará)');

        // Inyección limpia al .env
        $path = base_path('.env');
        $content = file_get_contents($path);
        $content = preg_replace('/DB_DATABASE=.*$/m', 'DB_DATABASE=' . $dbName, $content);
        $content = preg_replace('/DB_USERNAME=.*$/m', 'DB_USERNAME=' . $dbUser, $content);
        $content = preg_replace('/DB_PASSWORD=.*$/m', 'DB_PASSWORD=' . ($dbPass ?? ''), $content);
        file_put_contents($path, $content);

        // 3. Simulación de carga visual para migraciones
        $this->output->title('Fase 3: Despliegue de Esquema');
        
        $this->output.="<info>Construyendo tablas relacionales...</info>\n";
        $this->withProgressBar(1, function () {
            $this->call('migrate:fresh');
        });
        $this->line("\n");

        // 4. Panel de Resumen Ejecutivo y Alerta de Seeders externos
        $this->output->title('Fase 4: Finalización y Dependencias Externas');

        $this->table(
            ['Componente', 'Estado'],
            [
                ['Entorno (.env)', 'Configurado'],
                ['Llave de Encriptación', 'Generada'],
                ['Esquema SQL', 'Migrado con éxito'],
                ['Seeders Institucionales', 'Pendientes (Ver Google Drive)']
            ]
        );

        $this->line('');
        $this->warn('   AVISO IMPORTANTE SOBRE DATOS OFICIALES:');
        $this->line(' Los seeders con la información real de los directorios no se autoejecutan');
        $this->line(' por seguridad. Debes descargarlos de la carpeta compartida en');
        $this->line(' <options=bold>Google Drive</> (junto con el manual técnico) e integrarlos en la ruta correspondiente.');
        $this->line('');

        $this->info('======================================================================');
        $this->info('    ¡INSTALACIÓN COMPLETADA CON ÉXITO!');
        $this->info('   Inicia el servidor local ejecutando: php artisan serve');
        $this->info('======================================================================\n');
    }
}