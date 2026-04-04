<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

final class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $weapons = ProductCategory::factory()->create([
            'name' => ['en' => 'Weapons', 'ru' => 'Оружие'],
        ]);

        $armor = ProductCategory::factory()->create([
            'name' => ['en' => 'Armor', 'ru' => 'Броня'],
        ]);

        $consumables = ProductCategory::factory()->create([
            'name' => ['en' => 'Consumables', 'ru' => 'Расходники'],
        ]);

        Product::factory()->count(5)->create([
            'category_id' => $weapons->id,
        ]);

        Product::factory()->count(5)->create([
            'category_id' => $armor->id,
        ]);

        Product::factory()->count(3)->create([
            'category_id' => $consumables->id,
        ]);
    }
}
