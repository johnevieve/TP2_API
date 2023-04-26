<?php

use App\Http\Controllers\MissileController;
use App\Http\Controllers\PartieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/battleship-ia/parties')->group(function () {
        Route::controller(PartieController::class)->group(function () {
            Route::post('/', 'store');
            Route::delete('/{id}', 'destroy');
        });

        Route::controller(MissileController::class)->group(function () {
            Route::prefix('/{id}/missiles')->group(function () {
                Route::post('/', 'store');
                Route::put('/{coordonees}', 'update');
            });
        });
    });
});
