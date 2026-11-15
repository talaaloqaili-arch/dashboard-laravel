<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('lecturers', LecturerController::class);

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/lectures', [LectureController::class, 'index'])
    ->name('lectures.index');
