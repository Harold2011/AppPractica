<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    // Mostrar todas las alternativas
    public function index()
    {
        $alternatives = Alternative::all();
        return view('alternatives.index', compact('alternatives'));
    }

    // Mostrar formulario para crear una nueva alternativa
    public function create()
    {
        return view('alternatives.create');
    }

    // Almacenar una nueva alternativa
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:500',
        ]);

        Alternative::create($request->all());
        return redirect()->route('alternatives.index')->with('success', 'Alternativa creada con éxito.');
    }

    // Mostrar el formulario para editar una alternativa
    public function edit(Alternative $alternative)
    {
        return view('alternatives.edit', compact('alternative'));
    }

    // Actualizar una alternativa
    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:500',
        ]);

        $alternative->update($request->all());
        return redirect()->route('alternatives.index')->with('success', 'Alternativa actualizada con éxito.');
    }

    // Eliminar una alternativa
    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Alternativa eliminada con éxito.');
    }
}
