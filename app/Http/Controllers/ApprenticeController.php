<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InfoStudent;
use Illuminate\Http\Request;
use App\Models\Program;

class ApprenticeController extends Controller
{
    public function index()
    {
        // Obtener solo los usuarios que tienen el rol de Aprendiz
        $apprentices = User::role('Aprendiz')->with('infostudent')->get();

        return view('apprentices.index', compact('apprentices'));
    }

    public function edit($id)
    {
        // Buscar al aprendiz por su id
        $apprentice = User::findOrFail($id);

        // Obtener todos los programas disponibles
        $programs = Program::all();

        // Retornar la vista con los datos del aprendiz y los programas
        return view('apprentices.edit', compact('apprentice', 'programs'));
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud, incluyendo los nuevos campos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'cedula' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:entry_date', // La fecha de fin debe ser posterior o igual a la fecha de entrada
            'program_id' => 'nullable|exists:program,id',
        ]);

        // Actualizar la información del usuario
        $apprentice = User::findOrFail($id);
        $apprentice->update($request->only('name', 'email', 'cedula'));

        // Buscar el registro de infostudents
        $infostudent = InfoStudent::where('user_id', $id)->first();

        if ($infostudent) {
            // Actualizar la información en la tabla infostudents
            $infostudent->update($request->only('entry_date', 'end_date', 'program_id'));
        } else {
            // Si no existe, crear un nuevo registro
            InfoStudent::create([
                'entry_date' => $request->entry_date,
                'end_date' => $request->end_date,
                'program_id' => $request->program_id,
                'user_id' => $id,
            ]);
        }

        return redirect()->route('apprentices.index')->with('success', 'Información actualizada exitosamente');
    }



    public function destroy($id)
    {
        // Buscar al aprendiz por su id
        $apprentice = User::findOrFail($id);

        // Eliminar el aprendiz
        $apprentice->delete();

        // Redirigir a la lista de aprendices con un mensaje de éxito
        return redirect()->route('apprentices.index')->with('success', 'Aprendiz eliminado exitosamente.');
    }
}
