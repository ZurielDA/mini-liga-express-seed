<?php

use App\Http\Controllers\Api\SportMatchController;
use App\Http\Controllers\Api\StandingsController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'save']);

Route::get('/matches', [SportMatchController::class, 'index']);
Route::post('/matches', [SportMatchController::class, 'save']);
Route::post('/matches/{id}/result', [SportMatchController::class, 'result']);

Route::get('/standings', [StandingsController::class, 'index']);
