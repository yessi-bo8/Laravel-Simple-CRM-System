<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ClientApiController;
use App\Http\Controllers\API\ProjectApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/projects', ProjectApiController::class)->names('api.projects');
    Route::apiResource('/clients', ClientApiController::class)->only(['index', 'show']);
    Route::apiResource('/users', UserApiController::class);
});