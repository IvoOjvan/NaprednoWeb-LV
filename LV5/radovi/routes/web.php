<?php

use App\Http\Controllers\DissertationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [RoleController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/update-role', [RoleController::class, 'updateRole'])->name('admin.users.updateRole');
});

Route::middleware(['auth', 'role:professor'])->group(function () {
    Route::get('/professor/dissertations', [RoleController::class, 'professorIndex'])->name('professor.index');
    Route::post('/professor/dissertations', [DissertationController::class, 'store'])->name('professor.storeDissertation');
    Route::get('/professor/dissertations/{dissertation_id}', [DissertationController::class, 'details'])->name('professor.dissertation.details');
    Route::post('/professor/dissertations/{dissertation_id}', [DissertationController::class, 'approveStudent'])->name("professor.approve_student");
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dissertations', [RoleController::class, 'studentIndex'])->name('student.index');
    Route::post("/student/dissertations/{dissertation_id}", [DissertationController::class, "storeStudentToDissertation"])->name("student.dissertations.select");
});

require __DIR__ . '/auth.php';
