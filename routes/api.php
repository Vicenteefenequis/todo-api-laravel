<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('me', 'profile')->middleware('auth:sanctum');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});


Route::controller(CategoryController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('categories', 'index');
    Route::post('categories', 'store');
    Route::get('categories/{id}', 'show');
    Route::put('categories/{id}', 'update');
    Route::delete('categories/{id}', 'destroy');
});

Route::middleware('auth:sanctum')->apiResource('todos', TodoController::class);
