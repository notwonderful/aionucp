<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RechargeType;
use App\Models\Recharge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recharge>
 */
final class RechargeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => $this->faker->numberBetween(1, 10000),
            'user_id' => User::factory(),
            'type' => RechargeType::TELEPORT,
            'date' => now(),
        ];
    }

    public function teleportedAt(\DateTimeInterface $date): static
    {
        return $this->state(fn () => [
            'date' => $date,
        ]);
    }
}
