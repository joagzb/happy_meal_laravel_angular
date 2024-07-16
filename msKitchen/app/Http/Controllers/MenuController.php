<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Dish;

class MenuController extends Controller
{
    public function __invoke()
    {
        // Get dishes and their associated ingredients
        $dishes = Dish::with(['recipes.ingredient'])->get();

        // Transform the collection of dishes
        return MenuResource::collection($dishes);
    }
}
