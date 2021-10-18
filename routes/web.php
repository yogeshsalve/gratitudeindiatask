<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;

Route::resource('exams', ExamController::class);

Route::get('/', function () {
    return view('welcome');
});