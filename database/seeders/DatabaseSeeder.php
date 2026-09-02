<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            EstadoSeeder::class,
            MunicipioSeeder::class,
            NivelGobiernoSeeder::class,
            EnteSeeder::class,
            SedeSeeder::class,
            PuestoSeeder::class,
        ]);

        if (config('seeders.allow_data_seeders')) {
            $this->call([
                UserSeeder::class,
                ContactoSeeder::class,
                AsignacionSeeder::class,
            ]);
        }
    }
}