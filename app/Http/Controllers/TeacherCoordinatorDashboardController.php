<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\InfoStudent;
use App\Models\SelectAlternative;
use Illuminate\Support\Facades\Auth;

class TeacherCoordinatorDashboardController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Inicializar programas y estudiantes
        $programs = collect();
        $studentIds = collect();

        // Obtener los programas asociados al usuario basado en su rol
        if ($user->hasRole('Coordinador')) {
            // Obtener programas y estudiantes asociados al coordinador
            $programs = $user->coordinatorPrograms()->with('selectAlternatives')->get();
            $studentIds = InfoStudent::whereIn('program_id', $programs->pluck('id'))->pluck('user_id');
        } elseif ($user->hasRole('Profesor')) {
            // Obtener programas y estudiantes asociados al profesor
            $programs = $user->programs()->withCount('selectAlternatives')->get();
            $studentIds = InfoStudent::whereIn('program_id', $programs->pluck('id'))->pluck('user_id');
        }

        // Obtener alertas relacionadas con los estudiantes de los programas
        $alerts = SelectAlternative::whereIn('user_id', $studentIds)
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($group) {
                return [
                    'user' => $group->first()->user,
                    'total_alerts' => $group->count(),
                    'has_selected_alternative' => $group->contains('has_selected_alternative', true),
                ];
        });

        // Enviar datos a la vista
        return view('teacher_coordinator.dashboard', compact('alerts', 'programs'));
    }
}
