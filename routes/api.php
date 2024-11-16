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

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::get('logout', [AuthController::class, 'logout']);

        Route::apiResource('categories', CategoryController::class);

        Route::group(['prefix' => 'todos'], function (){
            Route::get('/', [TodoController::class, 'index']);
            Route::post('/', [TodoController::class, 'store']);
            Route::get('/{id}', [TodoController::class, 'show']);
            Route::put('/{id}', [TodoController::class, 'update']);
            Route::delete('/{id}', [TodoController::class, 'destroy']);
            Route::patch('/{id}/status', [TodoController::class, 'change_status']);
        });
    });
});


