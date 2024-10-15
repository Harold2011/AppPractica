<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoStudent;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'agreement' => 'required',
            'entry_date' => 'required|date',
            'end_date' => 'nullable|date',
            'program_id' => 'required|exists:program,id', // Validación para que el programa exista
        ]);

        $agreement = $request->has('agreement') ? 1 : 0;

        InfoStudent::create([
            'agreement' => $agreement,
            'entry_date' => $request->entry_date,
            'end_date' => $request->end_date,
            'program_id' => $request->program_id, // Relación con el programa
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Información de estudiante guardada.');
    }


    // Método para mostrar el formulario de edición
    public function edit()
    {
        $studentInfo = InfoStudent::where('user_id', Auth::id())->first();
        $programs = Program::all(); // Obtener todos los programas
    
        return view('student.edit', compact('studentInfo', 'programs'));
    }
    

    // Método para actualizar la información
    public function update(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program,id', // Validación para que el programa exista
        ]);
    
        $studentInfo = InfoStudent::where('user_id', Auth::id())->first();
    
        $studentInfo->update([
            'program_id' => $request->program_id, // Actualizamos el programa
        ]);
    
        return redirect()->route('dashboard')->with('status', 'Información de estudiante actualizada.');
    }
    

}
