<?php

use App\Http\Controllers\PartieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('battleship-ia')
    ->controller(PartieController::class)
    //->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/parties', 'create');
        Route::post('/parties/{id}/missiles', 'store');
        Route::put('/parties/{id}/missiles/{coordonnées}', 'update');
        Route::delete('/parties/{id}', 'destroy');
    });
