<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;


Route::prefix('stock')->group(function () {
	Route::post('ingredients',[IngredientController::class,'requestIngredients']);
	Route::get('',[IngredientController::class,'getStock']);

    Route::get('purchases',PurchaseController::class);
});
