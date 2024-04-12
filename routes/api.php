<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

//Public routes
// Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/projects', ProjectController::class)->names('api.projects');
    Route::apiResource('/clients', ClientController::class);
    Route::apiResource('/users', UserController::class);
});