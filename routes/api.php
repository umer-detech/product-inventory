<?php

use App\Http\Controllers\API\TranslationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('translations', TranslationController::class);
    Route::get('translations/export/json', [TranslationController::class, 'export']);
});


// Route::post('/oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');