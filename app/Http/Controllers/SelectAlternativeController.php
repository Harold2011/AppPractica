<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SelectAlternative;
use Illuminate\Support\Facades\Auth;

class SelectAlternativeController extends Controller
{
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'alternative_id' => 'required|exists:alternative,id',
            'description' => 'required|string|max:255',
        ]);

        // Crear una nueva selección de alternativa
        SelectAlternative::create([
            'user_id' => Auth::id(),
            'alternative_id' => $request->alternative_id,
            'description' => $request->description,
        ]);

        // Redirigir a la dashboard o donde desees
        return redirect()->route('dashboard')->with('success', 'Alternativa seleccionada con éxito.');
    }
}
