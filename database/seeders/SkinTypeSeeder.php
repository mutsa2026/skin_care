<?php

namespace Database\Seeders;

use App\Models\SkinType;
use Illuminate\Database\Seeder;

class SkinTypeSeeder extends Seeder
{
    public function run()
    {
        $skinTypes = [
            ['name' => 'Normal', 'description' => 'Well-balanced skin'],
            ['name' => 'Oily', 'description' => 'Excess sebum production'],
            ['name' => 'Dry', 'description' => 'Lack of moisture'],
            ['name' => 'Combination', 'description' => 'Mix of oily and dry areas'],
            ['name' => 'Sensitive', 'description' => 'Easily irritated skin'],
        ];

        foreach ($skinTypes as $skinType) {
            SkinType::create($skinType);
        }
    }
}