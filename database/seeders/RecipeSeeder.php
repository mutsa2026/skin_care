<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $recipes = [
            [
                'title' => 'Soothing Aloe Vera Mask',
                'description' => 'A calming mask perfect for irritated or sunburned skin',
                'instructions' => 'Mix 2 tablespoons of aloe vera gel with 1 teaspoon of honey. Apply to clean face and leave for 15-20 minutes. Rinse with warm water.',
                'preparation_time' => 5,
                'skin_type_id' => 5, // Sensitive
                'difficulty_level' => 'easy',
                'servings' => 1,
                'ingredients' => [
                    ['id' => 1, 'quantity' => '2', 'measurement_unit' => 'tablespoons'], // Aloe Vera Gel
                    ['id' => 2, 'quantity' => '1', 'measurement_unit' => 'teaspoon'] // Honey
                ]
            ],
            [
                'title' => 'Hydrating Honey Oatmeal Mask',
                'description' => 'Gentle exfoliation and deep hydration for dry skin',
                'instructions' => 'Mix 2 tablespoons ground oatmeal with 1 tablespoon honey and 1 tablespoon yogurt. Apply to face and massage gently. Leave for 10 minutes then rinse.',
                'preparation_time' => 5,
                'skin_type_id' => 3, // Dry
                'difficulty_level' => 'easy',
                'servings' => 1,
                'ingredients' => [
                    ['id' => 2, 'quantity' => '1', 'measurement_unit' => 'tablespoon'], // Honey
                    ['id' => 3, 'quantity' => '2', 'measurement_unit' => 'tablespoons'], // Oatmeal
                    ['id' => 7, 'quantity' => '1', 'measurement_unit' => 'tablespoon'] // Yogurt
                ]
            ],
            [
                'title' => 'Brightening Lemon Honey Scrub',
                'description' => 'Natural exfoliation and brightening for dull skin',
                'instructions' => 'Mix 1 tablespoon honey with 1 teaspoon lemon juice and 1 tablespoon sugar. Gently massage onto damp skin for 1-2 minutes. Rinse thoroughly.',
                'preparation_time' => 3,
                'skin_type_id' => 1, // Normal
                'difficulty_level' => 'easy',
                'servings' => 1,
                'ingredients' => [
                    ['id' => 2, 'quantity' => '1', 'measurement_unit' => 'tablespoon'], // Honey
                    ['id' => 6, 'quantity' => '1', 'measurement_unit' => 'teaspoon'] // Lemon Juice
                ]
            ],
            [
                'title' => 'Anti-Inflammatory Turmeric Mask',
                'description' => 'Reduces inflammation and brightens skin tone',
                'instructions' => 'Mix 1 teaspoon turmeric powder with 1 tablespoon yogurt and 1 teaspoon honey. Apply to face and leave for 10-15 minutes. Rinse with cool water.',
                'preparation_time' => 5,
                'skin_type_id' => 2, // Oily
                'difficulty_level' => 'easy',
                'servings' => 1,
                'ingredients' => [
                    ['id' => 8, 'quantity' => '1', 'measurement_unit' => 'teaspoon'], // Turmeric Powder
                    ['id' => 7, 'quantity' => '1', 'measurement_unit' => 'tablespoon'], // Yogurt
                    ['id' => 2, 'quantity' => '1', 'measurement_unit' => 'teaspoon'] // Honey
                ]
            ],
            [
                'title' => 'Deep Hydration Coconut Oil Treatment',
                'description' => 'Intensive moisture treatment for very dry skin',
                'instructions' => 'Warm 1 tablespoon coconut oil between palms. Massage into clean, damp skin. Leave overnight or for at least 30 minutes before rinsing.',
                'preparation_time' => 2,
                'skin_type_id' => 3, // Dry
                'difficulty_level' => 'easy',
                'servings' => 1,
                'ingredients' => [
                    ['id' => 4, 'quantity' => '1', 'measurement_unit' => 'tablespoon'] // Coconut Oil
                ]
            ]
        ];

        foreach ($recipes as $recipeData) {
            $ingredients = $recipeData['ingredients'];
            unset($recipeData['ingredients']);

            $recipe = Recipe::create($recipeData);

            foreach ($ingredients as $ingredient) {
                $recipe->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'measurement_unit' => $ingredient['measurement_unit']
                ]);
            }
        }
    }
}
