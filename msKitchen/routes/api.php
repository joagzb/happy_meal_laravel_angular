<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProvisioningWebhookController;
use Illuminate\Support\Facades\Route;


Route::prefix('kitchen/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'create']);
});

Route::prefix('kitchen/menu')->group(function () {
    Route::get('/', MenuController::class);
});

Route::prefix('webhook')->group(function () {
    Route::post('/ingredients/availability', ProvisioningWebhookController::class);
});
