<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ProjectController;
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
Route::resource('tasks', TaskController::class);