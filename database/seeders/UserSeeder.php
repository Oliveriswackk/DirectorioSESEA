<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador Demo',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'),
            'role_id' => 1,
            'activo' => true,
        ]);

        User::create([
            'name' => 'Coordinador Demo',
            'email' => 'coordinador@example.com',
            'password' => Hash::make('123456789'),
            'role_id' => 2,
            'activo' => true,
        ]);

        User::create([
            'name' => 'Colaborador Demo',
            'email' => 'colab@example.com',
            'password' => Hash::make('123456789'),
            'role_id' => 3,
            'activo' => true,
        ]);
    }
}