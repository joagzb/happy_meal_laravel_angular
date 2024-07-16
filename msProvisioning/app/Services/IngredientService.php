<?php

namespace App\Services;

use App\Http\DTOs\IngredientDTO;
use App\Models\Ingredient;

class IngredientService
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService,)
    {
        $this->purchaseService = $purchaseService;
    }

    public function handleIngredientStock(string $ingredientName, int $requestedQuantity): IngredientDTO
    {
        $fetchedAmount = $this->fetchFromStock($ingredientName, $requestedQuantity);
        $availability = $fetchedAmount == $requestedQuantity;

        return new IngredientDTO($ingredientName, $requestedQuantity, $availability);
    }

    public function fetchFromStock(string $ingredientName, int $ingredientQuantity): int
    {
        $fetchedAmount = 0;

        $stockIngredient = Ingredient::where('name', $ingredientName)->first();
        if ($stockIngredient->isAvailable($ingredientQuantity)) {
            $fetchedAmount = $ingredientQuantity;
            $stockIngredient->decrementStock($ingredientQuantity);
        } else {
            $fetchedAmount = $stockIngredient->quantity;
            $buyAmount = $ingredientQuantity - $stockIngredient->quantity;
            $this->purchaseService->dispatchBuyOrder($stockIngredient, $buyAmount);
        }

        return $fetchedAmount;
    }
}
