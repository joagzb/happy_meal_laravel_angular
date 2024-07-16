<?php

namespace Database\Seeders;

use App\IngredientEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = array_column(IngredientEnum::cases(), 'value');
        foreach ($ingredients as $ingredientName) {
            DB::table('ingredients')->insert([
                'name' => $ingredientName,
                'quantity' => 5,
            ]);
        }
    }
}
