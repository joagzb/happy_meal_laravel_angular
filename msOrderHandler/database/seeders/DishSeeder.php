<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dishes = ['dish1','dish2','dish3','dish4','dish5'];
        foreach ($dishes as $dish) {
            DB::table('dishes')->insert([
                'name' => $dish,
            ]);
        }
    }
}
