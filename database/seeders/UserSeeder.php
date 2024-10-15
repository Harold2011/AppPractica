<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear el usuario Admin
        $admin = User::create([
            'name' => 'Admin User',
            'cedula' => '000000004',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Asegúrate de cambiar esta contraseña
        ]);
        // Asignar el rol Admin
        $admin->assignRole('Admin');

        // Crear el usuario Aprendiz
        $aprendiz = User::create([
            'name' => 'Aprendiz User',
            'cedula' => '000000003',
            'email' => 'aprendiz@example.com',
            'password' => Hash::make('password'), // Cambiar esta contraseña también
        ]);
        // Asignar el rol Aprendiz
        $aprendiz->assignRole('Aprendiz');

        // Crear el usuario Profesor
        $profesor = User::create([
            'name' => 'Profesor User',
            'cedula' => '000000002',
            'email' => 'profesor@example.com',
            'password' => Hash::make('password'), // Cambiar esta contraseña
        ]);
        // Asignar el rol Profesor
        $profesor->assignRole('Profesor');

        // Crear el usuario Coordinador
        $coordinador = User::create([
            'name' => 'Coordinador User',
            'cedula' => '000000001',
            'email' => 'coordinador@example.com',
            'password' => Hash::make('password'), // Cambiar esta contraseña
        ]);
        // Asignar el rol Coordinador
        $coordinador->assignRole('Coordinador');
    }
}
