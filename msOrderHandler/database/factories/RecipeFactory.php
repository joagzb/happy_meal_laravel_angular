<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dish_id' => Dish::inRandomOrder()->first()->id,
            'ingredient_id' => Ingredient::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(1, 3),
        ];
    }
}
