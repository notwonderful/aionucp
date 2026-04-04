<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PromoCode>
 */
final class PromoCodeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::upper(Str::random(10)),
            'toll' => $this->faker->numberBetween(10, 1000),
            'user_id' => User::factory(),
        ];
    }

    public function withToll(int $amount): static
    {
        return $this->state(fn () => [
            'toll' => $amount,
        ]);
    }
}
