<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('tasks.index'); // Correction du chemin de la vue
});

// Dashboard accessible seulement après connexion et vérification
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::patch('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');



// Routes pour les tâches, protégées par l'authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // ✅ Correction ici
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update'); // ✅ Correction ici
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // ✅ Correction ici
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/mark-task-completed/{task}', [TaskController::class, 'markAsCompleted']);
    Route::get('/task-status/{task}', [TaskController::class, 'getTaskStatus']);
});

// Routes pour le profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclusion des routes d'authentification de Laravel Breeze
require __DIR__ . '/auth.php';
