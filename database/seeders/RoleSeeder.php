<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Aprendiz']);
        Role::create(['name' => 'Profesor']);
        Role::create(['name' => 'Coordinador']);
    }
}
