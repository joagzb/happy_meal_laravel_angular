<?php

namespace Database\Seeders;

use App\IngredientEnum;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{

    private $dishes = [
        'Tomato Salad' => [IngredientEnum::Tomato, IngredientEnum::Lettuce, IngredientEnum::Onion],
        'Lemon Chicken' => [IngredientEnum::Lemon, IngredientEnum::Chicken],
        'Potato Soup' => [IngredientEnum::Potato, IngredientEnum::Chicken],
        'Rice and Meat' => [IngredientEnum::Rice, IngredientEnum::Onion, IngredientEnum::Meat],
        'Burger' => [IngredientEnum::Ketchup, IngredientEnum::Meat, IngredientEnum::Lettuce, IngredientEnum::Cheese],
        'Lettuce Wrap' => [IngredientEnum::Lettuce, IngredientEnum::Chicken, IngredientEnum::Lemon],
        'Onion Rings' => [IngredientEnum::Onion, IngredientEnum::Potato, IngredientEnum::Cheese, IngredientEnum::Ketchup],
        'Meat Stew' => [IngredientEnum::Meat, IngredientEnum::Potato, IngredientEnum::Onion],
        'Chicken Curry' => [IngredientEnum::Chicken, IngredientEnum::Rice, IngredientEnum::Onion, IngredientEnum::Tomato],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->dishes as $dishName => $dishIngredients) {
            $dish = Dish::create(['name' => $dishName]);

            foreach ($dishIngredients as $ingredientEnum) {
                $ingredient = Ingredient::where('name', $ingredientEnum->value)->first();
                Recipe::create([
                    'dish_id' => $dish->id,
                    'ingredient_id' => $ingredient->id,
                    'amount' => rand(1, 3),
                ]);
            }
        }
    }
}
