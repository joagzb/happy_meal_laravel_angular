<?php

namespace App\Services;

use App\Jobs\PurchaseIngredient;
use App\Models\Ingredient;
use App\Models\Purchase;
use App\PurchaseStatusEnum;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PurchaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function dispatchBuyOrder(Ingredient $ingredient, int $quantityNeeded): void
    {
        Log::info("No " . $ingredient->name . " available. Dispatching buy order: " . $ingredient->name . " - " . $quantityNeeded);

        $purchase = Purchase::create([
            'ingredient_id' => $ingredient->id,
            'amount' => $quantityNeeded,
            'amountPending' => $quantityNeeded,
            'status' => PurchaseStatusEnum::PENDING,
            'buyAttempts' => 0,
        ]);

        PurchaseIngredient::dispatch($purchase)->onQueue('purchases');
    }
}
