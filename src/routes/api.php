<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::prefix('items')->middleware('apikey')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/decrypt', [ItemController::class, 'decryptResponse']);
    Route::get('{id}', [ItemController::class, 'show']);
    Route::post('/', [ItemController::class, 'store']);
    Route::put('{id}', [ItemController::class, 'update']);
    Route::delete('{id}', [ItemController::class, 'destroy']);
});

Route::prefix('transactions')->middleware('apikey')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/decrypt', [TransactionController::class, 'decryptResponse']);
    Route::get('{id}', [TransactionController::class, 'show']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::put('{id}', [TransactionController::class, 'update']);
    Route::delete('{id}', [TransactionController::class, 'destroy']);
});

