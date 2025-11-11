<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $ingredients = [
            [
                'name' => 'Aloe Vera Gel',
                'benefits' => 'Soothes irritated skin, hydrates dry skin, reduces inflammation',
                'usage_instructions' => 'Apply directly to skin or mix with other ingredients',
                'type' => 'gel'
            ],
            [
                'name' => 'Honey',
                'benefits' => 'Natural humectant, antibacterial properties, gentle exfoliant',
                'usage_instructions' => 'Use raw honey, mix with water for masks',
                'type' => 'liquid'
            ],
            [
                'name' => 'Oatmeal',
                'benefits' => 'Soothes itchy skin, removes impurities, gentle exfoliation',
                'usage_instructions' => 'Ground into powder, mix with water or yogurt',
                'type' => 'powder'
            ],
            [
                'name' => 'Coconut Oil',
                'benefits' => 'Deep hydration, antioxidant properties, anti-inflammatory',
                'usage_instructions' => 'Warm slightly before applying, use as moisturizer',
                'type' => 'oil'
            ],
            [
                'name' => 'Green Tea',
                'benefits' => 'Antioxidant rich, reduces inflammation, soothes skin',
                'usage_instructions' => 'Brew tea, cool, and use as toner or in masks',
                'type' => 'liquid'
            ],
            [
                'name' => 'Lemon Juice',
                'benefits' => 'Natural brightener, exfoliates dead skin cells',
                'usage_instructions' => 'Dilute with water, use sparingly on skin',
                'type' => 'liquid'
            ],
            [
                'name' => 'Yogurt',
                'benefits' => 'Lactic acid gently exfoliates, hydrates skin',
                'usage_instructions' => 'Use plain yogurt, apply as mask',
                'type' => 'dairy'
            ],
            [
                'name' => 'Turmeric Powder',
                'benefits' => 'Anti-inflammatory, brightens skin, reduces acne',
                'usage_instructions' => 'Mix with honey or yogurt, apply as paste',
                'type' => 'powder'
            ]
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
