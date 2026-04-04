<?php

declare(strict_types=1);

namespace Database\Factories\Game;

use App\Contracts\PasswordEncrypterContract;
use App\Models\Game\AccountData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<AccountData>
 */
final class AccountDataFactory extends Factory
{
    protected $model = AccountData::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::lower($this->faker->unique()->userName()),
            'email' => Str::lower($this->faker->unique()->safeEmail()),
            'password' => app(PasswordEncrypterContract::class)->encrypt('password'),
            'toll' => $this->faker->numberBetween(0, 10000),
        ];
    }

    public function withBalance(int $amount): static
    {
        return $this->state(fn () => [
            'toll' => $amount,
        ]);
    }

    public function broke(): static
    {
        return $this->state(fn () => [
            'toll' => 0,
        ]);
    }
}
