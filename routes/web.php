<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiteracyHourController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para panel de profesores
Route::get('/literacy-hours/teacher/create', [LiteracyHourController::class, 'createForTeacher'])->name('literacy_hours.teacher.create');
Route::post('/literacy-hours/teacher/store', [LiteracyHourController::class, 'storeForTeacher'])->name('literacy_hours.teacher.store');
Route::get('/literacy-hours/approve', [LiteracyHourController::class, 'approveList'])->name('literacy_hours.approve.list');
Route::post('/literacy-hours/approve/{id}', [LiteracyHourController::class, 'approve'])->name('literacy_hours.approve');
Route::get('/literacy-hours/group-monitor', [LiteracyHourController::class, 'groupMonitor'])->name('literacy_hours.group_monitor');

// Rutas para panel de estudiantes
Route::get('/literacy-hours/student/create', [LiteracyHourController::class, 'createForStudent'])->name('literacy_hours.student.create');
Route::post('/literacy-hours/student/store', [LiteracyHourController::class, 'storeForStudent'])->name('literacy_hours.student.store');
Route::get('/literacy-hours/student/progress', [LiteracyHourController::class, 'studentProgress'])->name('literacy_hours.student.progress');
