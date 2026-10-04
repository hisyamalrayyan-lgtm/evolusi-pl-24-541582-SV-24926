<?php

use App\Http\Controllers\TugasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tugas', [TugasController::class, 'index']);
Route::post('/tugas', [TugasController::class, 'store']);
Route::get('/tugas/{tugas}', [TugasController::class, 'show']);
Route::put('/tugas/{tugas}', [TugasController::class, 'update']);
Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy']);
