<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dish extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $table = 'dishes';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get all of the orders for the Dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all of the recipes for the Dish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function getIngredients()
    {
        // Get the dish recipe ingredients as a collection of ingredient IDs and their corresponding amounts
        $ingredients = $this->recipes->pluck('amount', 'ingredient_id');
        $ingredientIds = $ingredients->keys()->toArray();

        // Retrieve ingredient names based on ingredient IDs
        $ingredientNamesAndIds = Ingredient::whereIn('id', $ingredientIds)->get()->keyBy('id');

        // Append the names to the ingredients array
        $ingredients = $ingredients->map(function ($amount, $ingredientId) use ($ingredientNamesAndIds) {
            return [
                'name' => $ingredientNamesAndIds[$ingredientId]->name,
                'quantity' => $amount
            ];
        });

        return $ingredients->values()->toArray();
    }
}
