<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ['en' => $this->faker->unique()->words(2, true), 'ru' => $this->faker->unique()->words(2, true)],
            'description' => ['en' => $this->faker->sentence(), 'ru' => $this->faker->sentence()],
            'category_id' => ProductCategory::factory(),
            'item_id' => $this->faker->numberBetween(100000, 999999),
            'item_qty' => $this->faker->numberBetween(1, 10),
            'toll' => $this->faker->numberBetween(10, 5000),
        ];
    }

    public function withToll(int $amount): static
    {
        return $this->state(fn () => [
            'toll' => $amount,
        ]);
    }
}
