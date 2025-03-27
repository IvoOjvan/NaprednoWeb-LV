<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute za tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post("/tasks", [TaskController::class, "store"])->name("tasks.store");

    Route::get('/tasks/{task_id}', [TaskController::class, 'details'])->name('tasks.details');
    Route::post('/tasks/{task_id}', [TaskController::class, 'store_completed_job'])->name('tasks.store_completed_job');
    Route::post('/tasks/{task_id}/edit', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('/tasks/{task_id}/add-collaborator', [TaskController::class, 'store_collaborator'])->name('tasks.store_collaborator');
    Route::delete('/tasks/{task_id}/remove-collaborator', [TaskController::class, 'destroy_collaborator'])->name('tasks.destroy_collaborator');
    Route::delete("/tasks/{task}", [TaskController::class, "destroy"])->name("tasks.destroy");
});

require __DIR__ . '/auth.php';
