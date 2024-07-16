<?php

use App\Http\Controllers\KitchenWebhookController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::prefix('stock')->group(function () {
    Route::get('ingredients',[StockController::class,'getIngredients'])->name('ingredients.stock');
    Route::get('purchases',[StockController::class,'getPurchases'])->name('ingredients.purchases');
});

Route::prefix('kitchen')->group(function () {
    Route::get('orders',[OrderController::class,'getOrders'])->name('kitchen.orders');
    Route::post('orders',[OrderController::class,'setOrder'])->name('kitchen.new.order');

    Route::get('menu', MenuController::class);
});

Route::prefix('webhook')->group(function () {
    Route::post('orders/{id}/ready', KitchenWebhookController::class);
});
