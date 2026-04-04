<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Referral>
 */
final class ReferralFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => md5(Str::random(10)),
            'user_id' => User::factory(),
            'earned' => 0,
        ];
    }

    public function withEarned(int $amount): static
    {
        return $this->state(fn () => [
            'earned' => $amount,
        ]);
    }
}
