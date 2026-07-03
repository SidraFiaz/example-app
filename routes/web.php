<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;

Route::get('/', function () {
    return view('welcome');
});


//  Route::get('/dashboard', function () { 
//     return view('dashboard');

//  })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])
->name('dashboard');


Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/student-dashboard', [StudentController::class, 'index'])->name('student');



Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');



Route::post('/student/store', [StudentController::class, 'store'])
    ->name('student.store');




Route::get('/student', [StudentController::class, 'index'])->name('student.index');

Route::get('/classes', [ClassesController::class, 'index'])->name('classes');
Route::get('/classes/create', [ClassesController::class, 'create'])->name('classes.create');
Route::post('/classes/store', [ClassesController::class, 'store'])->name('classes.store');
Route::get('/classes/edit/{id}', [ClassesController::class, 'edit'])->name('classes.edit');
Route::put('/classes/update/{id}', [ClassesController::class, 'update'])->name('classes.update');
Route::delete('/classes/delete/{id}', [ClassesController::class, 'destroy'])->name('classes.delete');
Route::get('/classes/{class_id}/sections', [SectionController::class, 'index'])->name('sections.index');

// Route::get('/classes/{class_id}/sections/create', [SectionController::class, 'create'])->name('sections.index');
// Route::post('/classes/{class_id}/sections/store', [SectionController::class, 'store'])->name('sections.store');
// Route::get('/classes/{class_id}/sections/create', [SectionController::class, 'create']);


Route::resource('student', StudentController::class);

require __DIR__.'/auth.php';