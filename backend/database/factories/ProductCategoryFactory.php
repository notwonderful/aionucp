<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCategory>
 */
final class ProductCategoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ['en' => $this->faker->unique()->word(), 'ru' => $this->faker->unique()->word()],
        ];
    }

    public function withParent(int $parentId): static
    {
        return $this->state(fn () => [
            'parent_id' => $parentId,
        ]);
    }
}
