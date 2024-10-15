<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoStudent;
use App\Models\Program;
use App\Models\Alert;
use App\Models\SelectAlternative;
use App\Models\TipAlternative;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Alternative;

class DashboardController extends Controller
{
    public function index()
    {
        // Verificar el rol del usuario autenticado
        $user = Auth::user();
        
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard'); // Redirigir a dashboard de admin
        } elseif ($user->hasRole('Aprendiz')) {
            // Continuar con la lógica del Aprendiz
            return $this->apprenticeDashboard();
        } elseif ($user->hasRole('Profesor') || $user->hasRole('Coordinador')) {
            return redirect()->route('teacher.coordinator.dashboard'); // Redirigir a dashboard de profesor/coordinador
        } else {
            abort(403, 'No tienes acceso a esta sección'); // Mostrar error si el rol no es válido
        }
    }

    // Lógica del dashboard del aprendiz
    private function apprenticeDashboard()
    {
        // Obtenemos la información del estudiante actual, si existe
        $studentInfo = InfoStudent::where('user_id', Auth::id())->first();
        $programs = Program::all();
        $tipAlternatives = TipAlternative::with('alternative')->get();

        // Inicializamos el porcentaje de progreso
        $progressPercentage = 0;

        // Verificamos si el usuario ya seleccionó una alternativa
        $selectedAlternative = SelectAlternative::where('user_id', Auth::id())->first();

        // Inicializamos la variable para el estado de la alerta
        $alertTriggered = false;

        // Inicializamos la variable para tres meses antes de la fecha de finalización
        $threeMonthsBeforeEnd = null;

        // Inicializamos la variable para las alternativas
        $alternatives = Alternative::all(); // Obtener todas las alternativas

        // Calculamos el progreso curricular
        if ($studentInfo && $studentInfo->entry_date && $studentInfo->end_date) {
            $startDate = Carbon::parse($studentInfo->entry_date);
            $endDate = Carbon::parse($studentInfo->end_date);
            $today = Carbon::now();

            // Total de días entre inicio y fin
            $totalDays = $startDate->diffInDays($endDate);

            // Días transcurridos desde la fecha de inicio
            $daysPassed = $startDate->diffInDays($today);

            // Verificamos que el total de días no sea cero antes de calcular el porcentaje
            if ($totalDays > 0) {
                // Calculamos el porcentaje (respetando el límite de 100%)
                $progressPercentage = min(100, ($daysPassed / $totalDays) * 100);
            } else {
                // Si totalDays es cero, se puede considerar que no hay progreso
                $progressPercentage = 100;
            }

            // Lógica para verificar si faltan 3 meses para la fecha de finalización
            $threeMonthsBeforeEnd = $endDate->subMonths(3);
            if ($today->greaterThanOrEqualTo($threeMonthsBeforeEnd)) {
                // Verificamos si ya se generó una alerta en el último mes
                $lastAlert = Alert::where('user_id', Auth::id())
                                  ->whereDate('date', '>=', Carbon::now()->subMonth())
                                  ->first();

                // Si no existe una alerta reciente, creamos una nueva
                if (!$lastAlert) {
                    Alert::create([
                        'user_id' => Auth::id(),
                        'date' => Carbon::now(),
                    ]);
                    $alertTriggered = true; // Marcamos que se generó una alerta
                }
            }
        }

        // Retornamos la vista del dashboard y pasamos la información del estudiante
        return view('dashboard', compact('studentInfo', 'progressPercentage', 'programs', 'tipAlternatives', 'alertTriggered', 'threeMonthsBeforeEnd', 'alternatives', 'selectedAlternative'));
    }
}
