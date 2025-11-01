<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\SportMatchController;
use App\Http\Controllers\Api\StandingsController;



Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);

Route::post('/matches/{id}/result', [SportMatchController::class, 'result']);

Route::get('/standings', [StandingsController::class, 'index']);
