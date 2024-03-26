<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(1, 666),
            'currency' => $this->faker->randomElement(Currency::cases()),
            'payment_system' => 'palych',
            'user_id' => User::factory(),
        ];
    }
}
