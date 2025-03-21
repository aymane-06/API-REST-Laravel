<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JWTMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', [UserController::class,'index'])->middleware('auth:sanctum');
Route::apiResource('user', UserController::class)->middleware(JWTMiddleware::class);
Route::apiResource('offers', 'App\Http\Controllers\OfferController')->middleware(JWTMiddleware::class);
// Authentication routes


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(JWTMiddleware::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Application routes
Route::apiResource('applications', 'App\Http\Controllers\ApplicationController')->middleware(JWTMiddleware::class);
Route::patch('applications/{application}/status', 'App\Http\Controllers\ApplicationController@changeStatus')->middleware(JWTMiddleware::class);
// Competences routes
Route::apiResource('competences', 'App\Http\Controllers\CompetencesController');