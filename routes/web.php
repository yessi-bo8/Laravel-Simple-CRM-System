<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/account', function () {
    return view('account');
});

Route::resource('projects', WebController::class);
Route::resource('clients', WebController::class);
Route::resource('tasks', TaskController::class)->except(['update']);
Route::patch('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout']);
