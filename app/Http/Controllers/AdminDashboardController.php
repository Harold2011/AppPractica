<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\SelectAlternative;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\InfoStudent;

class AdminDashboardController extends Controller
{
    // Dentro de AdminDashboardController
    public function index(Request $request)
    {
        // Obtener las alertas agrupadas por usuario, paginando 10 registros por página
        $alertsQuery = Alert::with('user')
            ->select('user_id', \DB::raw('count(*) as total_alerts'))
            ->groupBy('user_id');

        // Verificar si hay un término de búsqueda por cédula
        if ($request->has('cedula') && $request->cedula) {
            $alertsQuery->whereHas('user', function ($query) use ($request) {
                $query->where('cedula', $request->cedula);
            });
        }

        // Obtener las alertas paginadas
        $alerts = $alertsQuery->paginate(10);

        // Verificar si el usuario ha registrado alguna alternativa
        foreach ($alerts as $alert) {
            $alert->has_selected_alternative = SelectAlternative::where('user_id', $alert->user_id)->exists();
        }

        // Obtener las alternativas agrupadas con su respectivo conteo
        $alternatives = SelectAlternative::select('alternative_id', \DB::raw('count(*) as total'))
            ->groupBy('alternative_id')
            ->with('alternative') // Cargar la relación de alternativa
            ->get();

        // Obtener la cantidad de alternativas seleccionadas por programa y paginarlas
        $programs = Program::withCount(['infostudents as select_alternatives_count' => function ($query) {
            $query->join('select_alternative', 'info_students.user_id', '=', 'select_alternative.user_id');
        }])->paginate(10); 

        return view('admin.dashboard', compact('alerts', 'alternatives', 'programs', 'request'));
    }
}
