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
            $programs = $user->coordinatorPrograms()->withCount('selectAlternatives')->get();
            $studentIds = InfoStudent::whereIn('program_id', $programs->pluck('id'))->pluck('user_id');
        } elseif ($user->hasRole('Profesor')) {
            // Obtener programas y estudiantes asociados al profesor
            $programs = $user->programs()->withCount('selectAlternatives')->get();
            $studentIds = InfoStudent::whereIn('program_id', $programs->pluck('id'))->pluck('user_id');
        }

        // Obtener todos los estudiantes, incluyendo aquellos que no han seleccionado alternativa
        $alerts = $studentIds->map(function ($studentId) {
            $alternatives = SelectAlternative::where('user_id', $studentId)->get();
            $user = \App\Models\User::find($studentId); // Busca el usuario directamente de la tabla 'users'
            
            return [
                'user' => $user,
                'total_alerts' => $alternatives->count(),
                'has_selected_alternative' => $alternatives->isNotEmpty(), // Verifica si hay una alternativa seleccionada
            ];
        });

        // Enviar datos a la vista
        return view('teacher_coordinator.dashboard', compact('alerts', 'programs'));
    }

}
