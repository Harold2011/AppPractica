<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'ficha' => 'required|max:255',
        ]);

        Program::create($request->all());

        return redirect()->route('programs.index')->with('success', 'Programa creado correctamente.');
    }

    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|max:255',
            'ficha' => 'Required|max:255'
        ]);

        $program->update($request->all());

        return redirect()->route('programs.index')->with('success', 'Programa actualizado correctamente.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Programa eliminado correctamente.');
    }
}
