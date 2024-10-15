<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener solo los usuarios que tienen el rol de Profesor o Coordinador
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Profesor', 'Coordinador']);
        })->with('roles')->get();
    
        return view('admin.index', compact('users'));
    }
    

    public function create()
    {
        $programs = Program::all();
        return view('admin.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'cedula' => 'required|string|max:20|unique:users', // Validación para cédula
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:3,4', // Rol 3=Profesor, 4=Coordinador
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cedula' => $request->cedula, // Guardar cédula
            'password' => bcrypt($request->password),
        ]);

        // Especifica el guard 'web' al buscar el rol
        $role = Role::findById($request->role, 'web');
        $user->assignRole($role);

        // Verificar los programas antes de asignar
        if ($request->role == 3) {
            $user->programs()->sync($request->programs); // Asignar programas a profesor
        } elseif ($request->role == 4) {
            $user->coordinatorPrograms()->sync($request->programs); // Asignar programas a coordinador
        }

        return redirect()->route('admin.index')->with('success', 'Usuario creado exitosamente.');
    }

    



    public function edit(User $user)
    {
        $programs = Program::all();
        return view('admin.edit', compact('user', 'programs'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:3,4',
            'programs' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Especifica el guard 'web' al buscar el rol
        $role = Role::findById($request->role, 'web');
        $user->syncRoles($role);

        if ($request->role == 3) {
            $user->programs()->sync($request->programs);
        } elseif ($request->role == 4) {
            $user->coordinatorPrograms()->sync($request->programs);
        }

        return redirect()->route('admin.index')->with('success', 'Usuario actualizado exitosamente.');
    }



    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
