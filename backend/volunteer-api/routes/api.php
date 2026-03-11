<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VolunteerController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/volunteers', [VolunteerController::class, 'index']);
    Route::get('/volunteers/{id}', [VolunteerController::class, 'show']);
    Route::post('/volunteers', [VolunteerController::class, 'store']);
    Route::put('/volunteers/{id}', [VolunteerController::class, 'update']);
    Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy']);

});