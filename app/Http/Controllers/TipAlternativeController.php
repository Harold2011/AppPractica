<?php

namespace App\Http\Controllers;

use App\Models\TipAlternative;
use App\Models\Alternative;
use Illuminate\Http\Request;

class TipAlternativeController extends Controller
{
    public function index()
{
    $tips = TipAlternative::with('alternative')->get();
    return view('tips.index', compact('tips'));
}


    public function create()
{
    $alternatives = Alternative::all();
    return view('tips.create', compact('alternatives'));
}

    public function store(Request $request)
    {
        $request->validate([
            'tip' => 'required|string|max:500',
            'alternative_id' => 'required|exists:alternative,id',
        ]);

        TipAlternative::create($request->all());

        return redirect()->route('tips.index')->with('success', 'Tip creado con éxito.');
    }

    public function edit(TipAlternative $tip)
    {
        $alternatives = Alternative::all(); 
        return view('tips.edit', compact('tip', 'alternatives'));
    }

    public function update(Request $request, TipAlternative $tip)
    {
        $request->validate([
            'tip' => 'required|string|max:500',
            'alternative_id' => 'required|exists:alternative,id',
        ]);

        $tip->update($request->all());

        return redirect()->route('tips.index')->with('success', 'Tip actualizado con éxito.');
    }

    public function destroy(TipAlternative $tip)
    {
        $tip->delete();
        return redirect()->route('tips.index')->with('success', 'Tip eliminado con éxito.');
    }
}
