<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory()->count(20)->create();
        $this->removeDuplicatedIngredients();
    }

    public function removeDuplicatedIngredients(): void
    {
        $duplicates = DB::table('recipes')
            ->select('dish_id', 'ingredient_id', DB::raw('COUNT(*) as count'))
            ->groupBy('dish_id', 'ingredient_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('recipes')
                ->where('dish_id', $duplicate->dish_id)
                ->where('ingredient_id', $duplicate->ingredient_id)
                ->limit($duplicate->count - 1)
                ->delete();
        }
    }
}
