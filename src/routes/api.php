<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('items')->middleware('apikey')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/decrypt', [ItemController::class, 'decryptResponse']);
    Route::get('{id}', [ItemController::class, 'show']);
    Route::post('/', [ItemController::class, 'store']);
    Route::put('{id}', [ItemController::class, 'update']);
    Route::delete('{id}', [ItemController::class, 'destroy']);
});
