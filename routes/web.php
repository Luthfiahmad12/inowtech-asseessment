<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Classroom;
use App\Livewire\Student;
use App\Livewire\Teacher;
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

    Route::get('classroom', Classroom::class)->name('classroom');
    Route::get('student', Student::class)->name('student');
    Route::get('teacher', Teacher::class)->name('teacher');
});

require __DIR__ . '/auth.php';
