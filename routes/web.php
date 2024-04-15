<?php

use App\Http\Controllers\Web\TaskWebController;
use App\Http\Controllers\Web\ClientWebController;
use App\Http\Controllers\Web\ProjectWebController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::resource('projects', ProjectWebController::class)->only(['index']);
Route::resource('clients', ClientWebController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
Route::resource('tasks', TaskWebController::class)->except(['update']);
Route::patch('tasks/{task}', [TaskWebController::class, 'update'])->name('tasks.update');
Route::resource('clients', ClientWebController::class);
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
