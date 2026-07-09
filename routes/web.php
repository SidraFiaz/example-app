<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Auth Routes
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Classes
    Route::get('/classes', [ClassesController::class, 'index'])->name('classes');
    Route::get('/classes/create', [ClassesController::class, 'create'])->name('classes.create');
    Route::post('/classes/store', [ClassesController::class, 'store'])->name('classes.store');
    Route::get('/classes/edit/{id}', [ClassesController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/update/{id}', [ClassesController::class, 'update'])->name('classes.update');
    Route::delete('/classes/delete/{id}', [ClassesController::class, 'destroy'])->name('classes.delete');

    // Sections
    Route::get('/classes/{class_id}/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/classes/{class_id}/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/classes/{class_id}/sections/store', [SectionController::class, 'store'])->name('sections.store');
    Route::delete('/classes/{class_id}/sections/delete/{id}', [SectionController::class, 'destroy'])->name('sections.delete');

    // AJAX Route
    Route::get('/get-sections/{class_id}', [SectionController::class, 'getSections'])->name('get.sections');

    // Students
    Route::resource('student', StudentController::class);

    // Subjects
    Route::resource('subjects', SubjectController::class);
});

require __DIR__ . '/auth.php';