<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\TipAlternativeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SelectAlternativeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherCoordinatorDashboardController;
use App\Http\Controllers\ApprenticeController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Middleware para autenticación y roles
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Verificar el rol de usuario y redirigir
    Route::get('/home', function () {
        $user = auth()->user();
        
        // Redirecciones basadas en rol
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Aprendiz')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('Profesor') || $user->hasRole('Coordinador')) {
            return redirect()->route('teacher.coordinator.dashboard');
        } else {
            abort(403, 'No tienes acceso a esta sección');
        }
    })->name('home');

    // Para el admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Para el Aprendiz
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Para profesor y coordinador
    Route::get('/teacher/coordinator/dashboard', [TeacherCoordinatorDashboardController::class, 'index'])->name('teacher.coordinator.dashboard');

    // Rutas de Alternativas y Tips
    Route::resource('alternatives', AlternativeController::class);
    Route::resource('tips', TipAlternativeController::class);

    // Nueva ruta para completar la información del estudiante
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/update', [StudentController::class, 'update'])->name('student.update');
    Route::resource('programs', ProgramController::class);

    // Nueva ruta para seleccionar alternativas
    Route::post('/select-alternative/store', [SelectAlternativeController::class, 'store'])->name('select_alternative.store');

    // Admin rutas adicionales
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/apprentices', [ApprenticeController::class, 'index'])->name('apprentices.index');
    Route::get('/apprentices/{id}/edit', [ApprenticeController::class, 'edit'])->name('apprentices.edit');
    Route::put('/apprentices/{id}', [ApprenticeController::class, 'update'])->name('apprentices.update');
    Route::delete('apprentices/{apprentice}', [ApprenticeController::class, 'destroy'])->name('apprentices.destroy');


});
