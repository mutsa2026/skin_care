<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SkinTypeSeeder::class,
            IngredientSeeder::class,
            RecipeSeeder::class,
        ]);
    }
}