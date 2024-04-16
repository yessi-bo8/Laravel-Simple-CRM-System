<?php

use App\Http\Controllers\Web\TaskWebController;
use App\Http\Controllers\Web\ClientWebController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});


Route::group(['middleware' => ['auth:sanctum']], function () {
Route::resource('tasks', TaskWebController::class)->names('tasks');
Route::resource('clients', ClientWebController::class)->except(['show']);
Route::get('/projects', function () {
    return view('projects.index');
});
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
