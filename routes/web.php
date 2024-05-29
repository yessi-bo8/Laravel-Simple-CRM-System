<?php

use App\Http\Controllers\Auth\GitHubAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Web\TaskWebController;
use App\Http\Controllers\Web\ClientWebController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/{page}', function () {
    return view('home');
})->where('page', 'home|main|');

Route::group(['middleware' => ['auth:sanctum']], function () {
Route::resource('tasks', TaskWebController::class)->names('tasks');
Route::resource('clients', ClientWebController::class)->except(['show', 'destroy']);
Route::get('/projects', function () {
    return view('projects.index');
});
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('login.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('login.google.callback');

Route::get('/getToken', [TokenController::class, 'getToken'])->middleware('auth:sanctum');