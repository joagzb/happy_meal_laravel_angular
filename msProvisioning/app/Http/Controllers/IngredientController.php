<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Services\IngredientService;

class IngredientController extends Controller
{
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService) {
        $this->ingredientService = $ingredientService;
    }

    public function requestIngredients(IngredientRequest $request): IngredientResource{
        $sendingIngredients = collect([]);

        foreach ($request->ingredients as $requestedIngredient) {
            $fetchedIngredient = $this->ingredientService->handleIngredientStock($requestedIngredient['name'], $requestedIngredient['quantity']);
            $sendingIngredients->push($fetchedIngredient);
        }

        return new IngredientResource($sendingIngredients);
    }

    public function getStock():IngredientResource{
        $ingredients = Ingredient::all();
        return new IngredientResource($ingredients);
    }
}
