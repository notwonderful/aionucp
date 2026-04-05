<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
final class ArticleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = ['update', 'event', 'maintenance', 'community', 'guide'];

        return [
            'title' => ['en' => $this->faker->sentence(4), 'ru' => $this->faker->sentence(4)],
            'excerpt' => ['en' => $this->faker->sentence(10), 'ru' => $this->faker->sentence(10)],
            'body' => ['en' => $this->faker->paragraphs(3, true), 'ru' => $this->faker->paragraphs(3, true)],
            'tag' => $this->faker->randomElement($tags),
            'published' => true,
            'published_at' => $this->faker->dateTimeBetween('-30 days'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'published' => false,
            'published_at' => null,
        ]);
    }
}
