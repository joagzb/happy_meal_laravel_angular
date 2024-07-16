<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;


Route::prefix('stock')->group(function () {
	Route::post('ingredients',[IngredientController::class,'requestIngredients'])->name('ingredients.request');
	Route::get('ingredients',[IngredientController::class,'getStock'])->name('ingredients.stock');

    Route::get('purchases',PurchaseController::class)->name('ingredients.purchases');
});
